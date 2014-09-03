<?php

	// URI security
	if (!defined('libellu5'))
		die('Direct access not permitted');
	
	
	/*==================== JOBS ====================*/
	
	$install_l5_jobs = $l5->sql("SHOW TABLES LIKE 'l5_jobs'",array());
	if (count($install_l5_jobs) === 0) {
	
		// This only executes if we have not installed
		$install_l5_jobs = $l5->sql('CREATE TABLE l5_jobs (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													name VARCHAR (50) NOT NULL,
													info TEXT,
													tasked TEXT NOT NULL,
													complete INT (1) NOT NULL DEFAULT 0,
													due INT (11) NOT NULL,
													project INT (11) NOT NULL,
													
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_jobs)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database. Please consult your logs to rectify the error',$l5);
		
		} else {
		
			// Fill table
		
		}
	
	}
	
	/*================== PAYMENTS ==================*/
	
	$install_l5_payments = $l5->sql("SHOW TABLES LIKE 'l5_payments'",array());
	if (count($install_l5_payments) === 0) {
	
		// This only executes if we have not installed
		$install_l5_payments = $l5->sql('CREATE TABLE l5_payments (
													
													id INT (11) NOT NULL AUTO_INCREMENT,
													amount INT (11) NOT NULL,
													info TEXT,
													payer TEXT NOT NULL,
													payee INT (11) NOT NULL,
													complete INT (1) NOT NULL DEFAULT 0,
													due INT (11) NOT NULL,
													project INT (11) NOT NULL,
													
													PRIMARY KEY ( id )
		)',array());
		
		if (!is_array($install_l5_payments)) {
		
			// The table could not be created:
			throw new error('libellu5 could not be installed as there was an error in the database: ' . $install_l5_payments,$l5);
		
		} else {
		
			// Fill table
		
		}
	
	}