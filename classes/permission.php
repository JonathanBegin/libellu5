<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class permission {
	
		private $levels;
		private $yourLevel;
		
		public function __construct ( $level ) {
		
			$this->yourLevel = $level;
			$this->levels = array (				'admin'		=> 5,
												'mod'		=> 4,
												'trusted'	=> 3,
												'user'		=> 2,
												'guest'		=> 1
											);
		
		}
		
		public function __toString () {
		
			return $yourLevel;
		
		}
		
		public function get () {
		
			return $yourLevel;
		
		}
		
		public function isGuest () {
			if ($this->yourLevel == 'guest')
				return true;
			return false;
		}
		
		public function isUser () {
			if ($this->yourLevel == 'user')
				return true;
			return false;
		}
		
		public function isTrusted () {
			if ($this->yourLevel == 'trusted')
				return true;
			return false;
		}
		
		public function isMod () {
			if ($this->yourLevel == 'mod')
				return true;
			return false;
		}
		
		public function isAdmin () {
			if ($this->yourLevel == 'admin')
				return true;
			return false;
		}
		
		public function isStaff () {
			if (($this->yourLevel == 'mod') || ($this->yourLevel == 'admin'))
				return true;
			return false;
		}
		
		public function isTrustedOrStaff () {
			if (($this->yourLevel == 'trusted') || (($this->yourLevel == 'mod') || ($this->yourLevel == 'admin')))
				return true;
			return false;
		}
		
		public function access ($level) {
		
			if ($this->levels[$level] <= $this->levels[$this->yourLevel])
				return true;
			else
				return false;
		
		}
	
	}