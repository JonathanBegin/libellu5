<?php
	
	/* Strips tags from POST data (keys and fields) */
	
	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class postdata implements ArrayAccess {
	
		private $container = array();
		
		public function __construct(array $POST) {
		
			foreach ($POST as $key => $value) {
			
				$this->container[strip_tags($key)] = strip_tags($value);
			
			}
		
		}
		
		public function offsetSet($offset, $value) {
			if (is_null($offset)) {
				$this->container[] = $value;
			} else {
				$this->container[$offset] = $value;
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