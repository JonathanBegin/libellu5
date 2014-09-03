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
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?=$setting['sitename']?>: <?=$this->l5->title()?></title>
		
		<!-- Styles -->
		<link rel="stylesheet" href="<?=$this->l5->HTMLRoot()?>css/foundation.css" />
		<link rel="stylesheet" href="<?=$this->l5->HTMLRoot()?>css/style.css" />
		<script src="<?=$this->l5->HTMLRoot()?>js/vendor/modernizr.js"></script>
		
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?=$this->l5->HTMLRoot()?>favicon.ico" />
		
	</head>
	
	<body>
		
		<nav class="top-bar" data-topbar>
			<ul class="title-area">
				<li class="name">
					<h1><a href="<?=$this->l5->HTMLRoot()?>"><?=$setting['sitename']?></a></h1>
				</li>
				
				<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
			</ul>
			
			<section class="top-bar-section">
				<!-- Right Nav Section -->
				<ul class="right">
					<li><a href="#">Welcome, <?=$you->username()?></a></li>
				</ul>

				<!-- Left Nav Section -->
				<ul class="left">
					<li><a href="#">Left Nav Button</a></li>
				</ul>
			</section>
		</nav>
		
		<div class="row">
		
			<div class="large-12 columns">
				
				<h1>libellu5</h1>
				
			</div>
			
		</div>
