<?php
	ob_start();
	session_start();
	$pageTitle = "404"; 
	include "init.php";

	if(isset($_SESSION['user'])){setcookie('user',$_SESSION['user'], time() + (86400 * 30),'/');}
	
	// if admin redirect the 404 page to fix a problem
	if(isset($_SESSION['Username'])) if($_SESSION['Username']) { header('location: 404.php'); exit();}
?>

<div style='margin-top:30px' class="text-center">
	<div class="container">
		<div class="row">  
            <div class="col-md-12">  
				<div style="    background-color: #fff;
								width: 60%;
								height: 60%;
								margin: auto;
								margin-bottom:100px">
					<?php
						echo '<span class="notfound" >404</span>';
						echo '<span style="display:block;color:red;font-size:20px" >الصفحة غير موجودة</span>';
						echo '<a class="btn btn-default btn-lg" href="index.php" style="display:block;color:#8e44ad">الصفحة الرئيسية</a>';
					?>
				</div>
            </div>
		</div>
	</div>
</div>

<?php
	include $tpl . "footer.php";
	ob_end_flush();
?>


