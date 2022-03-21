<?php include "Cpanel/connect.php"; ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bal 		= $_POST['balance1'];
    $u          = $_POST['me1'];

    if(isset($bal)){
        $stmt = $conn ->prepare("UPDATE users SET balance = balance - $bal WHERE Username = ?");
        $stmt->execute(array($u));
        if($stmt){
            echo $u . "sd" . $bal;
        }
    }
}
   
?>