<!--
//index.php
!-->

<?php
	ob_start();
	session_start();
	$pageTitle = "chating"; 
	include "init.php";



if(!isset($_SESSION['user']))
{
 header("location:login.php");
}

?>
 
  <!-- <link rel="stylesheet" href="jquery/jquery-ui.css">
        <link rel="stylesheet" href="bootstrap/bootstrap.css">
  <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="jquery/jquery-ui.min.js"></script> -->
    
    <div class="container">
   <br />
   
   <!-- <h3 style="text-align:center">Chat Application using PHP Ajax Jquery</h3><br /> -->
   <br />
   
   <div class="table-responsive">
    <!-- <h4 style="text-align:center">Online User</h4> -->
    <h2 style="text-align:center">الرسائل - <?php echo $_SESSION['user'];  ?></h2>
    <div style="text-align:right" id="user_details"></div>
    <div id="user_model_details"></div>
   </div>
  </div>
 




 <?php
	include $tpl . "footer.php";
	ob_end_flush();
?>