<?php
	ob_start();
	session_start();
	$pageTitle = "الصفحة الرئيسية"; 
	include "init.php";
 
	if(isset($_SESSION['user'])){setcookie('user',$_SESSION['user'], time() + (86400 * 30),'/');}
	
?>
<section class='header'>
	<?php
	$one = getOneFrom('img','settings','WHERE id=1');
	if(empty($one['img'])){
	?><script> $(".header").css({backgroundImage:"url('Cpanel/upload/img/main.jpg')"});</script><?php
	}else{
	
		?><script> $(".header").css({backgroundImage:"url('Cpanel/upload/img/<?php echo $one['img'] ?>')"});</script><?php
	// echo "
	// <script> $('.header').css({backgroundImage:'url(".$one['img'].")'});</script>
	
	// ";
	}
	?>

	
	<?php if(isset($_SESSION['user'])){

	}else{?>
	<div class="text-center">
		<a href="login.php" class="btn btn-warning bhome" >دخول</a>
	</div>
	<?php }?>
</section>

<span class='arrow'>
	<i class="fa fa-chevron-down fa-lg"></i>
</span>

<div style='margin-top:100px' class="home">
	<div class="container">

		<div class="row">    
			<?php
				$all = getAllFrom('*','items','where Approve = 1','','item_ID','DESC LIMIT 12');
				foreach($all as $item){
					if($item['Approve'] == 1){
					echo "<div class='col-sm-6 col-md-3'>";
						echo "<a style='text-decoration:none' href='items.php?itemid=". $item['item_ID'] . "'>";
							echo "<div class='thumbnail item-box index-box-sh'>";
								// echo "<span class='price'>$". $item['Price'] ."</span>";
								//echo "<img src='avatar.png' class='img-responsive' alt='User' />";
								echo "<div style=' height:200px;'>";
									if(!empty($item['Image'])){
									echo "<img src='Cpanel/upload/items/" . $item['Image'] . "' title='".$item['Name']."' alt='".$item['Name']."' class='img-responsive' style='width:100%; height:200px;' />";
									}else{
										echo "<img src='Cpanel/upload/items/items.jpg' title='".$item['Name']."' alt='".$item['Name']."' class='img-responsive ' style='width:100%; height:100%' />";
									}
								echo "</div>";
								echo "<div class='caption'>";
									echo "<h3 style='color:blue;font-weight:bold'>" . $item['Name'] . "</h3>";
									echo "<p>" . $item['Description'] . "</p>";
									// echo "<span>".$item['Add_Date']."</span>";
								echo "</div>";
							echo "</div>";
						echo "</a>";
					echo "</div>";
					}
				}
			?>
		</div>
	</div>
</div>
<div class="text-center" style="margin:30px;"><a href="allServices.php" class="btn btn-success">عرض جميع الخدمات</a></div>
<!-- Start Section Stats -->

        
<section class="statistics text-center">
            <div class="data">
                <div class="container">
                    <h2 class="h1">إحصائيات الموقع</h2>
                    <div class="row">
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="stats">
                                <i class="fa fa-users fa-5x"></i>
                                <p><?php  echo countItems("Username" , "users") ?></p>
                                <span>عدد الأعضاء في الموقع</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="stats">
                                <i class="fa fa-comments fa-5x"></i>
                                <p><?php  echo countItems("comment" , "comments") + countItems("id" , "order_comments");?></p>
                                <span>التعليقات على الموقع</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="stats">
                                <i class="fa fa-suitcase fa-5x"></i>
                                <p><?php echo countItems("id" , "notification")?></p>
                                <span>العمليات في الموقع</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="stats">
                                <i class="fa fa-support fa-5x"></i>
                                <p><?php echo countItems("item_ID" , "items");?></p>
                                <span>عدد الخدمات في الموقع</span>
                            </div>
                        </div>
                        
                    </div>
                </div>  
            </div>
        </section>
        
        <!-- End Section Stats -->

<?php
	include $tpl . "footer.php";
	ob_end_flush();
?>


