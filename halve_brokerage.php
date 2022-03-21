<?php 



	
    session_start();

	include 'Cpanel/connect.php';
	include 'includes/functions/functions.php';

	$brokerage =($_POST['price'] * 0.10);


$stmt = $conn->prepare("update users set balance = balance + ".$brokerage." where UserID = 11");

$stmt->execute();

$count = $stmt->rowCount();

if($count > 0){
        echo $brokerage;
} else {
    echo 0;
}



