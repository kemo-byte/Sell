<?php
	ob_start();
	session_start();
	$pageTitle = "Profile"; 
	include "init.php";
	
	if(isset($_SESSION['user'])){
	
	$getUser = $conn ->prepare("SELECT * FROM users WHERE Username=?");
	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

?>


<h1 class="text-center"><?php echo lang('PROFILE')?></h1>

<div class="information  block">
	<div class="container">
		<div class="panel panel-warning" >
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff"><?php echo lang('information')?></div>
			<div class="panel-body">
            <?php
            // print_r($_SESSION);
$u = getUser('where UserID=' . $_GET['userid'].'');
if($_SESSION['user'] == $u['Username']){
echo "<i class='fa fa-info-circle fa-lg' style='posistion:absolute;color: lime;background-color: lime;border-radius: 50%;'></i>";
}else{

// online or not



	$query = "
SELECT * FROM users 
WHERE UserID = '".$_GET['userid']."' 
";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetch();
$status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($result['UserID'], $conn);
 if($user_last_activity > $current_timestamp)

{echo "<i class='fa fa-info-circle fa-lg' style='posistion:absolute;color: lime;background-color: lime;border-radius: 50%;'></i>";} else{

    echo "<i class='fa fa-info-circle fa-lg' ></i>";}

}
if(!empty($u['avatar'])){
	echo "<img src='Cpanel/upload/avatar/" . $u['avatar'] . "'class='my-img img-circle img-thumbnail' alt='User' />";
	}else{
	?> <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /><?php
	}
?> 
				<ul class="list-unstyled">
					<li>
					<i class="fa fa-unlock-alt fa-fw"></i>
					<span><?php echo lang('name')?> :</span> <?php echo $u['Username'] ; ?>
					</li>
					
					<li>
					<i class="fa fa-envelope-o fa-fw"></i>
					<span><?php echo lang('email')?> :</span> <?php echo $u['Email'] ; ?>
					</li>
					<li>
					<i class="fa fa-user fa-fw"></i>
					<span><?php echo lang('fullname')?> :</span> <?php echo $u['FullName'] ;?>
					</li>
					<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span><?php echo lang('register_date')?> :</span> <?php echo $u['Date'] ;?>
					</li>
					<li>

					<a href="person.php?item_id=1&his_id=<?php echo $_GET['userid']?>&my_id=<?php  echo $_SESSION['uid']?>" class="btn btn-success btn-lg">إرفاق ملفات <?php // echo lang('contact')?></a>
					</li>
				</ul>
			
			
			
			<!-- contact to use -->


			<script>
					var i = <?php echo $_GET['userid'];?>;
					function fetch_one()
					{
						$.ajax({
						url:"fetch_one1.php",
						method:"POST",
						data:{i},
						success:function(data){ console.log(data);
							$('#user_details3').html(data);
						}
						})
					}
					fetch_one();
			</script>

				<?php if(isset($_SESSION['user'])){ ?>
              
              
							
						 
							<div class="table-responsive">
							<!-- <h4 style="text-align:center">Online User</h4> -->
							<div style="text-align:right" id="user_details3"></div>
							<div id="user_model_details"></div>
						</div>

							 
					<?php } ?>
				<!-- <span style="display:block">
                <a href="person.php?item_id=<?php //echo $item['item_ID']?>&his_id=<?php // echo $item['Member_ID']?>&my_id=<?php //echo $_SESSION['uid']?>" >تواصل مع البائع</a>
              </span> -->
			</div>
		</div>
		
	</div>
</div>

<div class="My-ads block" id="Ads">
	<div class="container">
		<div class="panel panel-warning">
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff"><?php echo lang('services')?></div>
			<div class="panel-body">
				<?php
					$all = getAllFrom('*','items','where Member_ID = ' . $u['UserID'] ,'','item_ID');
					 if(!empty($all)){
						echo "<div class='row'>";
						foreach(getItems('Member_ID',$u['UserID']) as $item){
							echo "<div class='col-sm-6 col-md-3'>";
							echo "<a style='text-decoration:none' href='items.php?itemid=". $item['item_ID'] . "'>";
							echo "<div class='thumbnail item-box'>";
								// echo "<span class='price'>$". $item['Price'] ."</span>";
								//echo "<img src='avatar.png' class='img-responsive' alt='User' />";
								echo "<div style=' height:200px;'>";
									if(!empty($item['Image'])){
									echo "<img src='Cpanel/upload/items/" . $item['Image'] . "' alt='' class='img-responsive' style='width:100%; height:200px;' />";
									}else{
										echo "<img src='Cpanel/upload/items/items.jpg' alt='' class='img-responsive ' style='width:100%; height:100%' />";
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
						echo "</div>";
					}else{
						echo "<div class='alert alert-warning'>لا توجد خدمات</div>";
					}


					?>
				
			</div>
		</div>
	</div>
</div>

<!-- <div class="My-comments block">
	<div class="container">
		<div class="panel panel-warning">
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff"><?php echo lang('COMMENTS')?></div>
			<div class="panel-body">
				<?php 


					// $all = getAllFrom('comment', 'comments', 'where  user_id =' . $u['UserID'] , '','c_id');
							
					// 	if(!empty($all)){
					// 		foreach($all as $comment){
					// 			echo "<p>" . $comment['comment'] . "</p>";
					// 		}
					// 	}else{
					// 		echo "There's No Comment To Show";
					// 	}

					?>
				</div>
			</div>
		</div>
	</div>
</div> -->

<?php

	}else{

		header('location: login.php');
		exit();
	}
	include $tpl . "footer.php";
	ob_end_flush();
?>