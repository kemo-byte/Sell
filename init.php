<?php

	// Error Reporting

	ini_set('dispay_errors','on');
	error_reporting(E_ALL);

	include 'Cpanel/connect.php';

	$sessionUser = '';
	
	if(isset($_SESSION['user'])){

		$sessionUser = $_SESSION['user'];
	}
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

