<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class error extends Exception {

		private $errormessage;
		private $l5;
		private $setting;
	
		public function __construct ( $message, libellu5 $l5 ) {
		
			if (is_string($message))
				$this->errormessage = '<div data-alert class="alert-box alert radius">' . $message . '<a href="#" class="close">&times;</a></div>';
			else
				$this->errormessage = '<div data-alert class="alert-box alert radius">An error occurred. In addition, there was an error creating the error message!<a href="#" class="close">&times;</a></div>';
			
			$html = new row (array(new block ($this->errormessage)));
			
			$this->l5 = $l5;
			include $this->l5->root() . 'inc/header.php';
			echo $html;
			
			die();
		
		}
	
	}