<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class job {
	
		private $l5;
		private $id;
		private $name;
		private $project;
		private $info;
		private $tasked = array();
		private $due;
		private $complete;
		
		public function __construct(libellu5 $l5, $id = null) {
			
			$this->l5 = $l5;
			
			if (isset($id)) {
			
				if (is_numeric($id)) {
				
					$attempt = $this->l5->sql('SELECT * FROM l5_jobs WHERE id = ?',array($id));
					
					if (!is_array($attempt))
						throw new error('Could not get job info due to a database error.',$this->l5);
						
					if (count($attempt) == 1) {
					
						$attempt = $attempt[0];
						
						$this->id = $attempt['id'];
						$this->name = $attempt['name'];
						$this->info = $attempt['info'];
						$this->due = timedate($attempt['due']);
						$this->project = new project($this->l5,$attempt['project']);
						
						$tasked = explode(',',$attempt['tasked']);
						foreach ($tasked as $taskedUser) {
							$this->tasked[] = new user($this->l5,$taskedUser);
						}
						
						if ($attempt['complete'] == '1')
							$this->complete = true;
						else
							$this->complete = false;
					
					} else
						throw new error('There is no job with that ID.',$this->l5);
				
				} else
					throw new error('Job ID must be a number.',$this->l5);
			
			}
		
		}
		
		public function create (user $you, $name, array $tasked, project $project, timedate $due, $info = null) {
		
			// Check permission
			$perms = new permission ($you->permission());
			$setting = new settings ($this->l5);
			
			if ($perms->access($setting['create job'])) {
			
				if (!is_string($name))
					throw new error ('Job name must be text.',$this->l5);
				
				if (empty($tasked))
					throw new error ('A job must have at least one person accomplishing it.',$this->l5);
				
				if (isset($info)) {
					if (!is_string($info))
						throw new error ('Job info must be text.',$this->l5);
				} else
					$info = '';
				
				// Set up tasked string
				$taskedSql = '';
				foreach ($tasked as $taskedUser) {
				
					$taskedSql .= $taskedUser->id() . ',';
				
				}
				$taskedSql = rtrim($taskedSql,',');
				
				// Set up project string
				$project = $project->id();
				
				// Set up due date
				$due = $due->db();
				
				// Attempt to insert
				$attempt = $this->l5->sql('INSERT INTO l5_groups (name,tasked,project,due,info) VALUES (?,?,?,?)',array($name,$tasked,$project,$due,$info));
				
				if (is_array($attempt)) {
				
					// Success
					return true;
				
				} else {
				
					// Database failure
					throw new error ('Could not create a new job because of a database error.',$this->l5);
				
				}
			
			} else
				throw new error ('You don\'t have permission to make a new job',$this->l5);
		
		}
	
	}