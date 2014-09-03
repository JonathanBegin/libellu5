<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class password {
	
		private $plaintext;
		private $hashed;
		private $hashedTwice;
		
		public function __construct ($plaintext,$cookie = null) {
		
			if (!$cookie) {
				$this->plaintext = $plaintext;
				$this->hashed = $this->encrypt($plaintext);
				$this->hashedTwice = $this->encrypt($this->hashed);
			} else {
				$this->hashed = $plaintext;
				$this->hashedTwice = $this->encrypt($plaintext);
			}
		
		}
		
		private function encrypt ($plaintext) {
		
			return crypt($plaintext,md5('libellu5 salt is the best'));
		
		}
		
		public function half () {
			return $this->hashed;
		}
		
		public function full () {
			return $this->hashedTwice;
		}
	
	}