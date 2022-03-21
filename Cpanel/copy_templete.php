<?php

	/*
	=====================================================
	== manage members page
	== You can Add | Edit | Delete members form  here
	=====================================================
	*/
		ob_start();

		session_start();

	if( isset($_SESSION['Username']) ){
		
		$pageTitle = 'Members';

		include "init.php";
		
		$do = isset($_GET['do'])? $_GET['do'] : 'manage';

		if($do == 'manage') {	// manage Members Page

		}elseif($do == 'Add'){  // Add Members Page
			

		}elseif($do == 'insert'){ // Insert Member Page


		}elseif($do == 'Edit'){ // Edit Page


		}elseif($do == 'update'){ // update page
		

		}elseif( $do == 'Delete'){


		} elseif( $do == "activate"){



		}include $tpl . "footer.php";

	}else{

		header('location: index.php');
		exit();
	}
	ob_end_flush();
?>