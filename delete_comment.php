<?php
session_start();

include 'Cpanel/connect.php'; 
include 'includes/functions/functions.php';

$de = $_POST['de'];

$stmt  = $conn->prepare("DELETE  FROM order_comments WHERE id=$de");

$stmt->execute();

if($stmt){
    echo 1;
}else{
    echo 0;
}



?>