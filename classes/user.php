<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class user {
		
		private $id;
		private $username;
		private $loggedIn;
		private $l5;
		private $warning;
		private $permission; // admin > mod > trusted > user > guest
		
		public function __construct (libellu5 $l5, $id = null) {
			
			$this->l5 = $l5;
			
			if ((!isset($id)) || (!is_numeric($id))) {
			
				// Set up default user
				$this->username = 'Guest';
				$this->id = 0;
				$this->permission = new permission('guest');
			
			} elseif (is_numeric($id)) {
			
				// Search the database for user with that ID
				$result = $this->l5->sql('SELECT * from l5_users WHERE id = ?',array($id));
				$result = $result[0];
				
				$this->id = $result['id'];
				$this->username = $result['username'];
				$this->permission = new permission($result['permission']);
			
			}
			
		}
		
		public function login ($username = null, password $password = null, $remember = null) {
			
			if (!isset($remember))
				$remember = true;
			
			// No point logging in if you're already logged in
			
			if (!$this->loggedIn) {
			
				// If no username or password set, check cookies
				if (((!$username) && (!$password)) && ((isset($_COOKIE['username'])) && (isset($_COOKIE['password'])))) {
				
					$username = $_COOKIE['username'];
					$password = new password($_COOKIE['password'],true);
				
				} else if ((!$username) && (!$password)) {
				
					$username = '';
					$password = new password('');
				
				}
				
				$attempt = $this->l5->sql('SELECT * FROM l5_users WHERE username = ? AND password = ?',Array($username,$password->full()));
				
				// Check it worked
				if (is_array($attempt)) {
				
					// No error, continue
					if (count($attempt) == 0) {
					
						// No user with that name/password combo
						return false;
						
					}
					
					// Log in with $attempt details
					
					// The password checks out, set the session up
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password->half();
					
					// If we are set to remember, set a cookie for 30 days with semi-encoded password. To be checked by header.
					if ($remember) {
						setcookie('username',$username,(time()+(60*60*24*30)),'/');
						setcookie('password',$password->half(),(time()+(60*60*24*30)),'/');
					} else {
						setcookie('username','',(time()-3100),'/');
						setcookie('password','',(time()-3100),'/');
					}
					
					// Set details from database
					$this->username = $username;
					$this->loggedIn = true;
					$this->permission = new permission ($attempt[0]['permission']);
					
					// Return the fact we've logged in
					return true;
				
				} else
					return false;
			
			} else
				return true;
		
		}
		
		// Log out
		public function logout () {
		
			if ($this->loggedIn) {
			
				// Simple: delete session info
				if (isset($_SESSION['username']))
					unset($_SESSION['username']);
				if (isset($_SESSION['password']))
					unset($_SESSION['password']);
				
				// If there's cookies, unset them
				setcookie('username','',(time() - 3600),'/');
				setcookie('password','',(time() - 3600),'/');
				
				$this->loggedIn = false;
				$this->id = 0;
				$this->username = 'Guest';
				$this->permission = new permission('guest');
			
			}
		
		}
		
		// Register a new user
		public function register ($username, $email, password $password) {
		
			if (!$this->loggedIn) {
			
				// Validate
				
				// 1: username
				if (!preg_match('$[a-zA-Z0-9 -_]{4,20}$',$username)) {
					$this->warning = new warning ('Registration failed: Username must be alphanumeric (hyphens, underscores and spaces allowed) and between 4 and 20 characters inclusive.');
					return false;
				} elseif (count($this->l5->sql('SELECT username FROM l5_users WHERE username = ?',array($username))) > 0) {
					$this->warning = new warning ('Registration failed: That username already exists!');
					return false;
				} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // 2: email
					$this->warning = new warning ('Registration failed: Email address is not valid.');
					return false;
				} else {
				
					$attempt = $this->l5->sql('INSERT INTO l5_users (username,email,password,joined,permission) VALUES (?,?,?,?,?)',array($username,$email,$password->full(),time(),'user'));
					
					if (!is_array($attempt)) {
					
						$this->warning = new warning ('Registration failed: Database error. Please try again or contact a website administrator.');
						return false;
					
					} else {
					
						if(!$this->login($username,$password)) {
						
							$this->warning = new warning ('Registration failed: Login details unusable.');
							return false;
						
						} else
							return true;
					
					}
				
				}
			
			} else {
			
				$this->warning = new warning ('Registration failed: you are already logged in.');
				return false;
			
			}
		
		}
		
		// Permission
		public function setPermission ($level,user $you) {
			
			$level = new permission ($level);
			
			// It's got to be a real permission level
			if (!array_key_exists($level,$this->permissionLevels))
				throw new error ('Tried to set a permission level that does not exist.',$this->l5);
			
			// Guests cannot change permission level
			elseif (($this->permission->isGuest()) || ($level->isGuest()))
				throw new error ('Guests cannot change permissions.',$this->l5);
			
			// Mods can only set levels lower than themselves
			elseif (($you->permission->isMod()) && (($level->isStaff()) || ($this->permission->isStaff())))
				throw new error ('You cannot set this user\'s permission to that level.',$this->l5);
			
			// Non-staff cannot set levels
			elseif (!$you->permission->isStaff())
				throw new error ('You cannot set another user\'s permission.',$this->l5);
			else {
			
				// We have permission to make the change
				$set = $this->l5->sql('UPDATE l5_users SET permission = ? WHERE id = ?',array($level->permission(),$this->id));
				if (!is_array($set))
					throw new error ($set,$this->l5);
				else {
				
					$this->permission = $level;
					return true;
				
				}
			
			}
		
		}
		
		// Printables
		
		public function id () {
			return $this->id;
		}
		
		public function username () {
			return $this->username;
		}
		
		public function loggedIn () {
			return $this->loggedIn;
		}
		
		public function permission () {
			return $this->permission->get();
		}
		
		public function warning () {
			return $this->warning;
		}
	
	}