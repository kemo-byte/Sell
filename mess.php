<?php
session_start();

include 'Cpanel/connect.php'; 
include 'includes/functions/functions.php';

$stmt = $conn->prepare("SELECT * FROM chat ");

?>