<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class payment {
	
		private $l5;
		private $id;
		private $amount;
		private $project;
		private $info;
		private $payer = array();
		private $payee;
		private $due;
		private $complete;
		
		public function __construct(libellu5 $l5, $id = null) {
			
			$this->l5 = $l5;
			
			if (isset($id)) {
			
				if (is_numeric($id)) {
				
					$attempt = $this->l5->sql('SELECT * FROM l5_payments WHERE id = ?',array($id));
					
					if (!is_array($attempt))
						throw new error('Could not get payment info due to a database error.',$this->l5);
						
					if (count($attempt) == 1) {
					
						$attempt = $attempt[0];
						
						$this->id = $attempt['id'];
						$this->amount = $attempt['amount'];
						$this->info = $attempt['info'];
						$this->due = timedate($attempt['due']);
						$this->to = new user($this->l5,$attempt['payee']);
						$this->project = new project($this->l5,$attempt['project']);
						
						$payer = explode(',',$attempt['payer']);
						foreach ($payer as $payerUser) {
							$this->for[] = new user($this->l5,$payerUser);
						}
						
						if ($attempt['complete'] == '1')
							$this->complete = true;
						else
							$this->complete = false;
					
					} else
						throw new error('There is no payment with that ID.',$this->l5);
				
				} else
					throw new error('Payment ID must be a number.',$this->l5);
			
			}
		
		}
		
		public function create (user $you, $name, array $payer, user $payee, project $project, timedate $due, $info = null) {
		
			// Check permission
			$perms = new permission ($you->permission());
			$setting = new settings ($this->l5);
			
			if ($perms->access($setting['create payment'])) {
			
				if (!is_numeric($amount))
					throw new error ('Payment amount must be numeric.',$this->l5);
				
				if (empty($payer))
					throw new error ('A payment must have at least one person paying it.',$this->l5);
				
				if (isset($info)) {
					if (!is_string($info))
						throw new error ('Payment info must be text.',$this->l5);
				} else
					$info = '';
				
				// Set up for string
				$payerSql = '';
				foreach ($payer as $payerUser) {
				
					$payerSql .= $payerUser->id() . ',';
				
				}
				$payerSql = rtrim($payerSql,',');
				
				// Set up to string
				$payee = $payee->id();
				
				// Set up project string
				$project = $project->id();
				
				// Set up due date
				$due = $due->db();
				
				// Attempt to insert
				$attempt = $this->l5->sql('INSERT INTO l5_groups (name,for,to,project,due,info) VALUES (?,?,?,?)',array($name,$payer,$payee,$project,$due,$info));
				
				if (is_array($attempt)) {
				
					// Success
					return true;
				
				} else {
				
					// Database failure
					throw new error ('Could not create a new payment because of a database error.',$this->l5);
				
				}
			
			} else
				throw new error ('You don\'t have permission to make a new payment',$this->l5);
		
		}
	
	}