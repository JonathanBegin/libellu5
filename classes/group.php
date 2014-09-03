<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class group {
	
		private $id;
		private $name;
		private $info;
		private $leaders = array();
		private $members = array();
		private $l5;
		
		public function __construct(libellu5 $l5, $id = null) {
		
			$this->l5 = $l5;
			
			if (isset($id)) {
			
				if (is_numeric($id)) {
				
					$info = $this->l5->sql('SELECT * FROM l5_groups WHERE id = ?',array($id));
					
					if (count($info) === 1) {
					
						$info = $info[0];
						
						// ID
						$this->id = $info['id'];
						
						// Name
						$this->name = new output ($info['name']);
						
						// Info
						$this->info = new output ($info['info']);
						
						// Leaders
						$leaders = explode($info['leaders']);
						foreach ($leaders as $leader) {
							$this->leaders[] = new user($this->l5,$leader);
						}
						
						// Members
						$members = explode($info['members']);
						foreach ($members as $member) {
							$this->members[] = new user($this->l5,$member);
						}
					
					} else
						throw new error ('There is no group with that group ID.',$this->l5);
				
				} else
					throw new error ('Group ID must be numeric.',$this->l5);
			
			}
		
		}
		
		public function create (user $you, $name, array $leaders, $info = null, array $members = null) {
		
			// Permission to create groups
			$perms = new permission ($you->permission());
			$setting = new settings ($this->l5);
			
			if ($perms->access($setting['create group'])) {
			
				if (!is_string($name))
					throw new error ('Group name must be text.',$this->l5);
				
				if (empty($leaders))
					throw new error ('Groups must have leaders.',$this->l5);
				
				if (isset($info)) {
					if (!is_string($info))
						throw new error ('Group info must be text.',$this->l5);
				} else
					$info = '';
				
				// Set up leader string
				$leaderSql = '';
				foreach ($leaders as $leader) {
				
					$leaderSql .= $leader->id() . ',';
				
				}
				$leaderSql = rtrim($leaderSql,',');
				
				// Set up member string
				if (isset($members)) {
				
					$memberSql = '';
					foreach ($members as $member) {
					
						$memberSql .= $member->id() . ',';
					
					}
					$memberSql = rtrim($memberSql,',');
				
				}
				
				// Attempt to insert
				$attempt = $this->l5->sql('INSERT INTO l5_groups (name,leaders,info,members) VALUES (?,?,?,?)',array($name,$leaderSql,$info,$memberSql));
				
				if (is_array($attempt)) {
				
					// Success
					return true;
				
				} else {
				
					// Database failure
					throw new error ('Could not create a new group because of a database error.',$this->l5);
				
				}
			
			} else
				throw new error ('You don\'t have permission to make a new group',$this->l5);
		
		}
		
		public function id() {
			return $this->id;
		}
	
	}