<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class output {
	
		private $text;
		
		public function __construct ($input = null) {
		
			if (isset($input)) {
				if (is_string($input)) {
					$this->text = utf8_encode(htmlspecialchars_decode(stripslashes($input)));
				}
			}
			
		}
		
		public function input ($input) {
		
			if (is_string($input))
				$this->text = utf8_encode(htmlspecialchars_decode(stripslashes($input)));
			
			return $this->text;
		
		}
		
		public function __toString() {
			return $this->text;
		}
	
	}