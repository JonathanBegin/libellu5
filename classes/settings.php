<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class settings implements ArrayAccess {
	
		private $container = array();
		private $l5;
		
		public function __construct(libellu5 $l5) {
			
			$this->l5 = $l5;
			
			// Fill array with settings
			$elements = $this->l5->sql('SELECT * FROM l5_settings',array());
			$elements = $elements[0];
			
			$this->container[$elements['setting']] = $elements['value'];
		
		}
		
		public function offsetSet($offset, $value) {
			if (is_null($offset)) {
				throw new error('Cannot create a setting without a setting name.',$this->l5);
			} else {
				$try = $this->l5->sql('UPDATE l5_settings SET value = ? WHERE setting = ?',array($value,$setting));
				
				if (is_array($try)) {
				
					$elements = $this->l5->sql('SELECT * FROM l5_settings WHERE setting = ?',array($setting));
					$elements = $elements[0];
					$this->container[$elements['setting']] = $elements['value'];
				
				} else {
				
					throw new error('Could not update setting due to a database error.',$this->l5);
				
				}
			}
		}
		
		public function offsetExists($offset) {
			return isset($this->container[$offset]);
		}
		
		public function offsetUnset($offset) {
			unset($this->container[$offset]);
		}
		
		public function offsetGet($offset) {
			return isset($this->container[$offset]) ? $this->container[$offset] : null;
		}
	
	}