<?php
	
	/* 
		Categories => [ Manage | Edit | Update | Add | Insert | Delete | Stats]
	*/

	$do = isset($_GET['do'])? $_GET['do'] : 'Manage';

	// if( isset($_GET['do'])){

	// 	$do = $_GET['do'];
	// }else{

	// 	$do = 'Manage';
	// }

	// if do equals main page

	if($do == 'Manage'){

		echo 'welcome to manage';
		echo '<a href="page.php?do=Add">Add</a>';
	}elseif($do == 'Edit'){

	}elseif($do == 'Update'){
		
	}elseif($do == 'Add'){
		
		echo 'welcome to Add Page';
	}elseif($do == 'Insert'){
		
	}elseif($do == 'Delete'){
		
	}elseif($do == 'Stats'){
		
	}else{

	}