<?php

	// Header
	
	// Get settings if necessary
	if (!isset($setting))
		$setting = new settings ($this->l5);
	
	// Create user if necessary
	if (!isset($you)) {
		$you = new user($this->l5);
		$you->login();
	}
	
?>
<!doctype html>
<html class="no-js" lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#">

	<head>
	
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!-- Meta information -->
		<title><?=$this->l5->title()?></title>
		<link rel="author" href="https://plus.google.com/u/0/118372041638494952803" />
		<meta name="description" content="Save the Date for jon and Stacey's Wedding!">
		
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.letsbegin.it/" />
		<meta property="og:title" content="Jon and Stacey - The Wedding" />
		<meta property="og:image" content="http://www.acejon.co.uk/img/me.jpg" />
		<meta property="og:description" content="Find out more about Jon and Stacey's wedding on April 11th, 2015!" />
		<meta property="fb:admins" content="513177522" />
		
		<!-- Styles -->
		<link rel="stylesheet" href="<?=$this->l5->HTMLRoot()?>css/foundation.css" />
		<link rel="stylesheet" href="<?=$this->l5->HTMLRoot()?>css/style.css" />
		<link rel="stylesheet" href="<?=$this->l5->HTMLRoot()?>css/savethedate.css" />
		<script src="<?=$this->l5->HTMLRoot()?>js/vendor/modernizr.js"></script>
		
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?=$this->l5->HTMLRoot()?>favicon.ico" />
		
	</head>
	
	<body>