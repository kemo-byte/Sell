<?php


    session_start();

	include 'Cpanel/connect.php';
	include 'includes/functions/functions.php';

	
$user = $_POST['uid'];
// check if there is a notifiction
$stmt2 = $conn->prepare("update  notification set status = 0 where seller=".$user);

$stmt2->execute();

$row = $stmt2->rowCount();

if($row > 0){ 
    echo 1;
} else {
    echo 0;
}