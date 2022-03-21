<?php
	ob_start();
	session_start();
	$pageTitle = "404 Admin"; 
	include "init.php";

	if(isset($_SESSION['user'])){setcookie('user',$_SESSION['user'], time() + (86400 * 30),'/');}
	
?>

<div style='margin-top:10%' class="text-center">
	<div class="container">
		<div class="row">  
            <div class="col-md-12">  
				<div style="    background-color: #222;
								color:#fff;
								font-size:5em;
								width: 60%;
								height: 60%;
								margin: auto;
								margin-bottom:100px">
					<?php
						echo '<span class="notfound" >404</span>';
						echo '<span style="display:block;color:red;font-size:0.3em" >الصفحة غير موجودة</span>';
						echo '<a class="btn btn-default btn-lg" href="index.php" style="display:block;color:blue">الصفحة الرئيسية</a>';
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


