<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class page {
	
		private $l5;
		private $rows;
		private $rendered;
		private $setting;
		private $header;
		private $scroll;
		
		public function __construct ( libellu5 $l5 ) {
		
			$this->l5 = $l5;
			$this->rows = array();
			$this->rendered = false;
			$this->header = 'header.php';
		
		}
		
		public function __destruct () {
		
			if (!$this->rendered) {
			
				foreach ($this->rows as $row) {
				
					echo $row;
					
				}
				
				include $this->l5->root() . 'inc/footer.php';
			
			}
		
		}
		
		public function header ($file) {
		
			if (is_string($file))
				$this->header = $file;
		
		}
		
		public function addRow ( row $row = null, $priority = null ) {
		
			if (!$priority)
				$this->rows[] = $row;
			else
				$this->rows = array_merge( array($row), $this->rows );
		
		}
		
		public function render (user $you = null, settings $setting = null) {
		
			if (!isset($you))
				$you = new user($this->l5);
			
				
			if (!isset($setting))
				$setting = new settings($this->l5);
		
			include $this->l5->root() . 'inc/' . $this->header;
			
			foreach ($this->rows as $row) {
			
				echo $row;
			
			}
			
			include $this->l5->root() . 'inc/footer.php';
			
			$this->rendered = true;
		
		}
		
		public function loginForm ($username = null, $redirect = null) {
		
			if (!isset($redirect))
				$redirect = 'home/loggedin';
			if (!isset($username))
				$username = '';
			
			// Create login form
			$loginForm = new form('login','POST',$this->l5);
			$loginForm->classes('radius');
			$loginForm->addInput('text','username','Enter your username or email','john@google.com&hellip;',$username);
			$loginForm->addInput('password','password','Enter your password','password&hellip;');
			$loginForm->addInput('checkbox','remember','Log in automatically next time?');
			$loginForm->addInput('hidden','redirect','','',$redirect);
			$loginForm->button('submit','Log in','medium radius');
			
			// Output
			$block = new block ('<h3>Log in</h3>' . $loginForm,'8 small-centered','6 medium-centered','4 large-centered');
			$row = new row (array($block));
			$this->addRow($row);
		
		}
		
		public function redirect ($url) {
			
			$arr = explode('/',$url);
			$first = $arr[0];
			
			if (file_exists($this->l5->root() . $first . '.php')) {
				header('Location: ' . $this->l5->HTMLRoot() . $url);
			} else {
				$this->addRow(new row(array(new block(new warning('Cannot redirect as target page does not exist')))));
			}
			$this->rendered = true;
		
		}
		
		public function scroll ($offset = null) {
		
			if (isset($offset))
				$this->scroll = $offset;
			else
				return $this->scroll;
		
		}
	
	}