<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class warning extends error {

		private $errormessage;
		private $html;
	
		public function __construct ( $message ) {
		
			if (is_string($message))
				$this->errormessage = '<div data-alert class="alert-box alert radius">' . $message . '<a href="#" class="close">&times;</a></div>';
			else
				$this->errormessage = '<div data-alert class="alert-box alert radius">An error occurred. In addition, there was an error creating the error message!<a href="#" class="close">&times;</a></div>';
			
			$this->html = new row (array(new block ($this->errormessage)));
		
		}
		
		public function __toString() {
		
			settype($this->html,'string');
			return $this->html;
		
		}
	
	}