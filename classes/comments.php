<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');

	class comments {
	
		private $container = array();
		private $l5;
		
		public function __construct(libellu5 $l5, $type, $id) {
			
			$this->l5 = $l5;
			
			// Make sure id is numeric
			if (!is_numeric($id))
				throw new error('Cannot load comments: parent ID must be numeric',$this->l5);
			
			
			// Fill array with comment IDs
			$elements = $this->l5->sql('SELECT id FROM l5_comments WHERE type = ? AND typeid = ? ORDER BY added ASC',array($type,$id));
			
			foreach ($elements as $element) {
				$this->container[] = new comment ($this->l5,$element['id']);
			}
			
		}
		
		public function display () {
		
			$html = '';
		
			foreach ($this->container as $comment) {
			
				$html .= $comment->display();
			
			}
			
			$html .= '';
			
			return $html;
		
		}
		
	}