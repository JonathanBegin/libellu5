<?php

	/*
	
		libellu5 is a OO PHP Foundation backend created by Jonathan Begin.
	
	*/
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------- URI MANAGEMENT -------------------------------*/
	/*------------------------------------------------------------------------------*/
	
	// Set up URI changes. Also note, some work is done in the .htaccess file to redirect every request to this page.
	$uri = ltrim($_SERVER['REQUEST_URI'],'/billboard-builder/');	// Fix URI
	$params = explode('/',$uri);						// Create an array from the URI
	$thisPage = strtolower(array_shift($params));			// Get the page name, in lowercase
	if ($thisPage == '') $thisPage = 'home';					// Turn a blank into a homepage case
	
	// List all safe pages here. This means backend scripts cannot be accessed, so long as they ask for libellu5 to be defined.
	$safePages = array('home');
	define('libellu5',true);
	
	// An unsafe page will result in a 404 for the user
	if(!in_array($thisPage, $safePages)) {	
		$thisPage = '404';
	}
	
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------ INCLUDE CLASSES -------------------------------*/
	/*------------------------------------------------------------------------------*/
	
	function __autoload($class) {
		
		$class = strtolower($class);
		
		// Load base classes
		if (file_exists('classes/' . $class . '.php'))
			include 'classes/' . $class . '.php';
		
		// Load module classes
		else {
		
			$modules = array_slice(scandir('modules'),2);
			foreach ($modules as $module) {
			
				if (file_exists('modules/' . $module . '/' . $class . '.php'))
					include 'modules/' . $module . '/' . $class . '.php';
			
			}
		
		}
    }
	
	/*------------------------------------------------------------------------------*/
	/*---------------------------------- FIX PHP -----------------------------------*/
	/*------------------------------------------------------------------------------*/
	
	// Checks if a given object can be used as a string. is_string() should do this.
	function canBeString ($item) {
	
		if(
			( !is_null( $item ) ) && 
			( ( !is_array( $item ) ) &&
			( ( !is_object( $item ) && settype( $item, 'string' ) !== false ) ||
			( is_object( $item ) && method_exists( $item, '__toString' ) ) ) )
		)
			return true;
		
		return false;
	
	}
	
	/*------------------------------------------------------------------------------*/
	/*---------------------------- DATABASE CONNECTION -----------------------------*/
	/*------------------------------------------------------------------------------*/
	
	// Include Database Host, Username, Password and Database
	
	$l5Host = 'localhost'; // We're connecting to our server
	$l5User = 'root'; // Database user
	$l5Pass = ''; // Database password
	$l5Database = 'build'; // Database to which we want to connect
	
	
	/*------------------------------------------------------------------------------*/
	/*--------------------------------- INITIALISE ---------------------------------*/
	/*------------------------------------------------------------------------------*/
	
	// Set default timezone
	date_default_timezone_set('UTC');
	
	// Start the session (allows users to be logged in)
	session_start();
	
	// Set root
	$l5HTMLRoot = '';
	foreach ($params as $p) {
		$l5HTMLRoot = '../' . $l5HTMLRoot;
	}
	
	// Instantiate libellu5 using the database settings and HTML root
	$l5 = new libellu5 ($l5Host, $l5User, $l5Pass, $l5Database, $l5HTMLRoot);
	
	// Check for database, and install if necessary
	include($l5->root() . 'inc/install.php');
	
	// Get settings
	$setting = new settings ($l5);
	
	// Create a user profile for the current user
	$you = new user ($l5);
	$you->login();
	
	// Start the page object
	$page = new page ($l5);
	
	// Run page script
	include $thisPage . '.php';