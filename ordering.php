<?php
	ob_start();
	session_start();
	$pageTitle = "Ordering"; 
	include "init.php";

	if(isset($_SESSION['user'])){setcookie('user',$_SESSION['user'], time() + (86400 * 30),'/');}
	
?>

<div style='margin-top:30px' class="text-right">
	<div class="container">
        <h1 class="text-center"> طلبات الخدمة غير الموجودة </h1>
		<div class="row">    
			<?php
				
				$all = getAllFrom('*','ordering','where Approve = 1','','order_ID');
				
				foreach($all as $order){
					$u = getUser('WHERE UserID='.$order["Member_ID"]);
					// echo '<div dir="ltr">'.$u['avatar'].'</div>';
					if($order['Approve'] == 1){
					echo "<div class='col-sm-12'>";
					
						// echo "<a style='text-decoration:none' href='items.php?itemid=". $order['order_ID'] . "'>";
							echo "<div class='thumbnail item-box'>";
								
								echo "<div class='row'>";
								echo "<div class='col-sm-10'>";

								echo "<div class='caption'>";
									echo "<a href='orders.php?order_id=". $order['order_ID'] . "'><h3 style='color:blue;font-weight:bold'>" . $order['order_name'] . "</h3></a>";
									// echo "<p>" . $order['Description'] . "</p>";
									echo "<br/><p>".$order['Add_date']."</p>";
									echo "</div>";
									echo "</div>";
									echo "<div class='col-sm-2 text-center' >";
									if(($u['avatar']) != ''){
									echo "<img style='width:130px;height:130px;left:0;top:0px;border-radius:50%' src='Cpanel/upload/avatar/".$u['avatar']."' />";
									}else{
										echo "<img style='width:130px;height:130px;left:0;top:0px;border-radius:50%' src='Cpanel/upload/avatar/avatar.png' />";
									}
									echo "<a href='p.php?userid=".$order['Member_ID']."' style='font-size:2em'>" . $u['Username'] . "</a>";
									echo "</div>";
									

								echo "</div>";
							echo "</div>";
						// echo "</a>";
					echo "</div>";
					}
				}
			?>
		<a class="btn btn-warning btn-lg" href="NewOrder.php">إضافة طلب </a>
		</div>

	</div>
</div>

<?php
	include $tpl . "footer.php";
	ob_end_flush();
?>


