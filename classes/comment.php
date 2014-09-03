<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class comment {
	
		private $l5;
		private $id;
		private $container;
		
		public function __construct(libellu5 $l5, $id = null) {
			
			$this->l5 = $l5;
			
			// Make sure id is numeric
			
			if (isset($id)) {
			
				if (!is_numeric($id))
					throw new error('Cannot load comment: ID must be numeric',$this->l5);
				
				$this->id = $id;
				
				// Fill array with comment IDs
				$this->container = $this->l5->sql('SELECT * FROM l5_comments WHERE id = ?',array($this->id))[0];
				
				$author = new user($this->l5,$this->container['author']);
				$this->container['author'] = $author->username();
				
				$time = new timedate($this->container['added']);
				$this->container['added'] = $time->ago();
				
				$this->container['content'] = new output ($this->container['content']);
			
			} else
				$this->id = null;
		
		}
		
		public function display () {
			
			if (is_numeric($this->id)) {
			
				$author = new output($this->container['author']);
				
				$html = '	<div class="comment">
								
								<h5> ' . $author . ' &bull; ' . $this->container['added'] . '</h5>
								<p>' . $this->container['content'] . '</p>
								
							</div>';
				
				return $html;
				
			} else return '';
		
		}
		
	}