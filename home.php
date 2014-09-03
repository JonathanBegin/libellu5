<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');
	
	$l5->setTitle('libellu5');
	
	////////// PAGE INFO
	
	$body = new element('p');
	$body->html('You have successfully installed libellu5!');
	$page->addRow(new row(array(new block($body))));
	
	////////// RENDER
	$page->render($you);