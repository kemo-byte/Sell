<?php include "connect.php"; ?>

<?php

	$username   = $_POST['username'];
	$password   = $_POST['password'];
	$bal 		= $_POST['balance'];

    if (isset($username)){

        $stmt = $conn ->prepare("SELECT password FROM users where username=?");
        $stmt->execute(array($username));
        
        $row = $stmt ->fetch();
    
        if(password_verify($password, $row['password'])){
            function pay($username,$bal){
			global $conn;
		    $stmt = $conn->prepare("SELECT * FROM users WHERE username='$username'");

		    $stmt->execute();
		    
		    $s  = $stmt->fetch();

		   if( $s['balance'] > 0){

		   	   $st = $conn->prepare("UPDATE users SET balance=balance-$bal WHERE username='$username'");
		   	   $st->execute();

		       echo 'Done!';

		   }else{

		       echo "less than or equal 0";

		   }

		}
		pay($username,$bal);

        }else{
            echo 0;
        }

}
?>