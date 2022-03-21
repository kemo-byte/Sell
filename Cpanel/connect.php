<?php

	$dsn = "mysql:host=localhost;dbname=shop_with_chat";
	$user = "root";
	$pass = "kemobyte";


	// date_default_timezone_set('Africa/Cairo');
	date_default_timezone_set('Asia/Kuwait');

	$option = array(

		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

	);

	try{
		
		$conn = new PDO($dsn, $user, $pass, $option);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e){
		echo 'failed ' . $e ->getMessage();
	}
