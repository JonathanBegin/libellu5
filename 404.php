<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');
	
	echo 'This is the 404 page. <br /><a href="' . $libellu5->HTMLRoot() . 'home">Home link</a>';