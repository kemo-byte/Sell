<?php
	
	include 'connect.php';
	// Routs
	$lang = 'includes/languages/'; // language dirctory
	$tpl = 'includes/templetes/'; // templete directory
	$func = 'includes/functions/'; // functions directory
	$css = 'layout/css/'; // css directory
	$js = 'layout/js/'; // js directory

	// include the important Files

	include $func . 'functions.php';
	include $lang . 'arabic.php';
	include $tpl . 'header.php';

	$brokerage = 0.20;

	// include navbar in pages except that have no navbar variabe
	if(!isset($noNavbar)){
		include $tpl . 'navbar.php';
	}
	

