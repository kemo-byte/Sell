<?php
session_start();
include "Cpanel/connect.php";


if(isset($_POST['submit'])){
    
$name = $_POST['name'];
$message = $_POST['message'];
$stmt = $conn ->prepare("INSERT INTO chat (Member_ID, message,it_ID) VALUES (?,?,$item_id)");
$stmt->execute(array($name,$message));

$run = $stmt->fetch();
echo $run['message'];
if($run){
    ?>
    <!-- <audio src='audio/notification.mp3' hidden='true' autoplay='true'> -->
    <?php
}
}
?>


