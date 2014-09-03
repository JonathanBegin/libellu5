<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class row extends element {
	
		protected $html;		// InnerHTML of element
		protected $elem;		// Element type i.e. div, span
		protected $eclass;	// Element classes i.e. 'row collapsed'
		protected $id;		// Element id i.e. 'customerName'
		protected $meta;		// Additional element attributes i.e. 'data-options="is_hover:true;" type="submit"'
		
		public function __construct ( array $blocks, $classes = null, $id = null, $meta = null ) {
			
			$this->elem = 'div';
			$this->eclass = ' class="row"';
			$this->html = '';
			
			$this->id = '';
			if (canBeString($id))
				$this->id = ' id="' . $id . '"';
			
			if (canBeString($classes))
				$this->eclass = rtrim($this->eclass,'"') . ' ' . $classes . '"';
			
			$this->meta = '';
			if (canBeString($meta))
				$this->meta = ' ' . $meta;
			
			foreach ($blocks as $block) {
				$this->html .= $block;
			}
			
		}
	
	}