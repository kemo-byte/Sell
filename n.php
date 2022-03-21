<?php



	
    session_start();

	include 'Cpanel/connect.php';
	include 'includes/functions/functions.php';

	
$user = $_POST['uid'];
// check if there is a notifiction
$stmt2 = $conn->prepare("select status from notification where seller=".$user . " and status = 1");

$stmt2->execute();

$row = $stmt2->rowCount();

if($row > 0){ 
    echo $row;
} else {
    echo 0;
}