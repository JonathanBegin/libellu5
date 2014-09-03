<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class element {
	
		protected $html;		// InnerHTML of element
		protected $elem;		// Element type i.e. div, span
		protected $eclass;	// Element classes i.e. 'row collapsed'
		protected $id;		// Element id i.e. 'customerName'
		protected $meta;		// Additional element attributes i.e. 'data-options="is_hover:true;" type="submit"'
		
		public function __construct ( $elem, $class = null, $id = null, $meta = null ) {
			
			if (canBeString($elem))
				$this->elem = $elem;
			else {
				throw warning('Element type must be a string! Set to &lt;div&gt;.');
				$this->elem = 'div';
			}
			
			$this->eclass = '';
			if (canBeString($class))
				$this->eclass = ' class="' . $class . '"';
			
			$this->id = '';
			if (canBeString($id))
				$this->id = ' id="' . $id . '"';
			
			$this->meta = '';
			if (canBeString($meta))
				$this->meta = ' ' . $meta;
			
			$this->html = '';
			
		}
		
		public function html ($html) {
		
			if (canBeString($html))
				$this->html .= $html;
			else
				throw warning('Inner HMTL of element ' . $this->elem . ' must be a valid string!');
		
		}
		
		public function __toString () {
			
			// Add meta info
			return '<' . $this->elem . $this->eclass . $this->id . $this->meta . '>' . $this->html . '</' . $this->elem . '>';
			
		}
	
	}