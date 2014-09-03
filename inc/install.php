<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');
	
	/*=============== HOW TO INSTALL ===============*/
	/*
		1. Create a blank database, or decide on an existing databse to use
		2. Open libellu5.php
		3. Edit the database login credentials
		4. Edit the $uri 'fixer' line near the top of libellu5.php if not installed on root
		5. Visit the dir that libellu5.php is located - the rest is automatic.
	*/
	
	/*================== SETTINGS ==================*/
	
	$install_l5_settings = $l5->sql("SHOW TABLES LIKE 'l5_settings'",array());
	if (count($install_l5_settings) === 0) {
	
		// This only executes if we have not installed
		$install_l5_settings = $l5->sql('CREATE TABLE l5_settings (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													setting VARCHAR (21) NOT NULL,
													value TEXT,
													
													UNIQUE ( setting ),
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_settings)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database. Please consult your logs to rectify the error',$l5);
		
		} else {
		
			// Fill table
			$l5->sql('INSERT INTO l5_settings (setting,value) VALUES (?,?)',array('sitename','libellu5'));
		
		}
	
	}
	
	/*================= USERS =================*/

	$install_l5_users = $l5->sql("SHOW TABLES LIKE 'l5_users'",array());
	if (count($install_l5_users) === 0) {
	
		// This only executes if we have not installed
		$l5_install_users = $l5->sql('CREATE TABLE l5_users (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													username VARCHAR (21) NOT NULL,
													password VARCHAR (50) NOT NULL,
													email VARCHAR (255) NOT NULL,
													firstname VARCHAR (100),
													lastname VARCHAR (100),
													joined INT (11) NOT NULL,
													permission VARCHAR (21) NOT NULL,
													birthday INT (11),
													bio TEXT,
													
													UNIQUE ( username ),
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_users)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database. Please consult your logs to rectify the error',$l5);
		
		} else {
		
			// Fill table
		
		}
	
	}
	
	/*================ COMMENTS ================*/

	$install_l5_comments = $l5->sql("SHOW TABLES LIKE 'l5_comments'",array());
	if (count($install_l5_comments) === 0) {
	
		// This only executes if we have not installed
		$l5_install_comments = $l5->sql('CREATE TABLE l5_comments (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													author INT (11) NOT NULL,
													type VARCHAR (50) NOT NULL,
													typeid INT (11) NOT NULL,
													added INT (11) NOT NULL,
													content TEXT,
													
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_comments)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database. Please consult your logs to rectify the error',$l5);
		
		} else {
		
			// Fill table
		
		}
	
	}
	
	
	/*================= GROUPS =================*/

	$install_l5_groups = $l5->sql("SHOW TABLES LIKE 'l5_groups'",array());
	if (count($install_l5_groups) === 0) {
	
		// This only executes if we have not installed
		$l5_install_groups = $l5->sql('CREATE TABLE l5_groups (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													leaders TEXT NOT NULL,
													name VARCHAR (50) NOT NULL,
													members TEXT,
													
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_groups)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database. Please consult your logs to rectify the error',$l5);
		
		} else {
		
			// Fill table
		
		}
	
	}
	
	
	/*================= MODULES =================*/
	
	$modules = array_slice(scandir('modules'),2);
	foreach ($modules as $module) {
	
		if (file_exists('modules/' . $module . '/install.php'))
			include 'modules/' . $module . '/install.php';
	
	}