<?php
	
	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class form {
	
		private $action;
		private $method;
		private $l5;
		private $classes;
		private $formClass;
		private $inputs;
		
		public function __construct ($action, $method, libellu5 $l5, $class = null) {
			
			if (!file_exists($l5->root() . $action . '.php'))
				throw new error('Post action "' . $l5->HTMLRoot() . $action . '.php" does not exist.',$l5);
			
			$method = strtoupper($method);
			
			if (($method != 'POST') && ($method != 'GET'))
				throw new error('Form method must be POST or GET.',$l5);
			
			$this->action = $action;
			$this->method = $method;
			$this->l5 = $l5;
			$this->classes = '';
			
			if (isset($class))
				$this->formClass = ' class="' . $class . '"';
			else
				$this->formClass = '';
			
		}
		
		public function classes ($input) {
			
			if(preg_match('$-?[_a-zA-Z]+[_a-zA-Z0-9-]*$',$input))
				$this->classes = $input;
			else
				throw new error ('Class name invalid.',$this->l5);
		
		}
		
		public function addInput ($type, $name, $label, $placeholder = null, $value = null) {
			
			// Type
			switch ($type) {
			
				case 'text':
				
					$input = '<div><label>%label%<input type="text" name="%name%" class="%classes%" placeholder="%placeholder%" value="%value%" /></label></div>';
				
				break;
				
				case 'email':
				
					$input = '<div><label>%label%<input type="email" name="%name%" class="%classes%" placeholder="%placeholder%" value="%value%" /></label><small class="error">Enter a valid email address.</small></div>';
				
				break;
				
				case 'textarea':
				
					$input = '<div><label>%label%<textarea name="%name%" class="%classes%">%value%</textarea></label></div>';
				
				break;
				
				case 'password':
				
					$input = '<div><label>%label%<input type="password" name="%name%" class="%classes%" placeholder="%placeholder%" /></label></div>';
				
				break;
				
				case 'checkbox':
				
					$input = '<div><input type="checkbox" name="%name%" id="%name%"><label for="%name%">%label%</label></div>';
				
				break;
				
				case 'hidden':
				
					$input = '<div><input type="hidden" name="%name%" class="%classes%" value="%value%" /></div>';
				
				break;
				
				default:
					throw new error ('Form input type unknown.',$this->l5);
				break;
			
			}
			
			// Name
			if (preg_match('$[a-zA-Z0-9-_]+$',$name))
				$input = str_replace('%name%',$name,$input);
			else
				throw new error('Form input name invalid.',$this->l5);
			
			// Placeholder
			if (isset($placeholder))
				$input = str_replace('%placeholder%',$placeholder,$input);
			
			// Value
			if (isset($value))
				$input = str_replace('%value%',$value,$input);
			else
				$input = str_replace('%value%','',$input);
			
			// Add label and put it all together
			$input = str_replace('%label%',$label,$input);
			
			$this->inputs[] = $input;
		
		}
		
		public function button ($name, $value, $classes = null) {
			
			if (isset($classes)) {
				$checkClasses = explode(' ',$classes);
				foreach ($checkClasses as $class) {
					if(!preg_match('$-?[_a-zA-Z]+[_a-zA-Z0-9-]*$',$class))
						throw new error ('Button class name invalid.',$this->l5);
				}
			} else
				$classes = '';
			
			$this->inputs[] = '<div><input type="submit" name="' . $name . '" value="' . $value . '" class="button ' . $classes . '" /></div>';
		
		}
		
		public function __toString () {
		
			$html = '<form data-abide action="' . $this->l5->HTMLRoot() . $this->action . '" method="' . $this->method . '"' . $this->formClass . '>';
			
			foreach ($this->inputs as $input) {
				$html .= $input;
			}
			
			$html .= '</form>';
			
			// Don't forget classes
			$html = str_replace('%classes%',$this->classes,$html);
			
			return $html;
		
		}
	
	}