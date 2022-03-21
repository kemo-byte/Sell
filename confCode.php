<?php
  session_start();

	include 'Cpanel/connect.php';
	include 'includes/functions/functions.php';


$email = $_POST['codeMail'];

$code = $_POST['code'];


$stmt2 = $conn->prepare("select * from users where Email=?");

$stmt2->execute([$email]);

$row = $stmt2->fetch()['code'];


if($row == $code){

$stmt = $conn->prepare("update users set code = 12345678 where Email = ?");

$stmt->execute([$email]);

$count = $stmt->rowCount();

if($count > 0) {
  echo 1;
} else {
  echo 2;
}

} else {
  echo 0;
}