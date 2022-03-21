<?php
	session_start();
	
	$n = '';
	$noNavbar = '';

	$pageTitle = 'login';

	if(isset($_SESSION['Username'])){
		header('location: Cpanel/dashboard.php');
	}
	include "init.php";


	// check if the user comming from Http Request

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		// check if the user exists in the database

		$stmt = $conn ->prepare("SELECT UserID,username,password FROM users WHERE username = ? AND password = ? AND GroupID = 1");
		$stmt->execute(array($username,$hashedPass));
		$row = 	$stmt ->fetch();
		$count = $stmt ->rowCount();

		// if count > 0    username found
		if($count > 0){
			$_SESSION['Username'] = $username;	// register username
			$_SESSION['ID'] = $row['UserID'];
			header('location:dashboard.php');
			exit();
		}else{
			echo "<div class='container text-center' style='position: relative;'>
			<div style='display:inline-block;' class='alert alert-danger'>إسم الستخدم أو كلمة المرور غير صحيحة</div></div>";
		}
	}


?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<h4 class="text-center"> Control Panel </h4>
		<input class="form-control" type="text" name="user" placeholder="<?php echo lang('username')?>" autocomplete="off">
		<input class="form-control" type="password" name="pass" placeholder="<?php echo lang('password')?>" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="<?php echo lang('login')?>">
	</form>
	
<?php

	include $tpl . "footer.php";
?>


