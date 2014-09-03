<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class block extends element {
	
		protected $html;		// InnerHTML of element
		protected $elem;		// Element type i.e. div, span
		protected $eclass;	// Element classes i.e. 'row collapsed'
		protected $id;		// Element id i.e. 'customerName'
		protected $meta;		// Additional element attributes i.e. 'data-options="is_hover:true;" type="submit"'
		protected $small;		// Behaviour on small screens
		protected $medium;	// Behaviour on medium screen
		protected $large;		// Behaviour on large screens
		
		public function __construct ( $content, $small = null, $medium = null, $large = null, $class = null, $id = null, $meta = null ) {
		
			if (isset($small))
				$this->small = ' small-' . $small;
			else
				$this->small = ' small-12';
			if (isset($medium))
				$this->medium = ' medium-' . $medium;
			if (isset($large))
				$this->large = ' large-' . $large;
			
			$this->elem = 'div';
			
			$this->eclass = ' class="';
			if (canBeString($class))
				$this->eclass .= $class . ' ';
			$this->eclass .=  ltrim($this->small . $this->medium . $this->large,' ') . ' columns"';
			
			$this->id = '';
			if (canBeString($id))
				$this->id = ' id="' . $id . '"';
			
			$this->meta = '';
			if (canBeString($meta))
				$this->meta = ' ' . $meta;
			
			$this->html = '';
			if (canBeString($content))
				$this->html = $content;
			
		}
	
	}