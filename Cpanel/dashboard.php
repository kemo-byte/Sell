<?php
	ob_start(); // Output Buffering start

	session_start();

	if( isset($_SESSION['Username']) ){

		$pageTitle =  "لوحة التحكم";
		
		include "init.php";

		$numUser = 6; // latest registered users
		$latestUsers = getLatest('*', 'users','UserID',$numUser); // function to get the latest users from the database
		
		$numItem = 6; // latest registered items
		$latestItems = getLatest('*','items','item_ID',$numItem); // Latest Items Array
		
		$numComment = 4; // latest comments
		?>
		<div class="home-stats">
			<div class='container  text-center'>
				<h1> <?php echo lang('dashboard')?> </h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-users"></i>
							<div class="info">
								<h4><?php echo lang('total')?></h4>
								<a href='Members.php'><span><?php echo countItems('UserID','users')?></span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
							<h4><?php echo lang('pending')?></h4>
								<a href="members.php?do=manage&page=pending"><span><?php echo activate("RegStatus","users","0")?></span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
							<h4>جميع الخدمات</h4>
								<a href="items.php?do=manage"><span><?php echo countItems('item_ID','items')?></span></a>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="stat st-comments">
							<i class="fa fa-comments"></i>
							<div class="info">
							<h4>جميع التعليقات</h4>
								<a href="comments.php?do=manage"><span><?php echo countItems('c_id','comments')?></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="latest">
			<div class="container ">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> آخر <?php  echo $numUser?> اعضاء مسجلين   
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>

							<div class="panel-body">
								<ul class="list-unstyled latest-users">
								<?php
									if(!empty($latestUsers)){
											
										foreach ($latestUsers as $user){
											if(!($user['GroupID']== 1)){
											echo '<li>';
												echo  $user['Username'] ;
												echo  '<a href="members.php?do=Edit&userid=' . $user['UserID'] .'" <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> '. lang('edit').'</span> </a> '; 
												
												if($user['RegStatus'] == 0){
									
													echo " <a href='members.php?do=activate&userid=" . $user['UserID'] . "' class='btn btn-info pull-right'> <i class='fa fa-check'></i> ".lang('activate')." </a> ";
									
													} 
											echo '</li>';
				}}}	else{
				echo "There's No Members To Show";
			}				?>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tags"></i> آخر <?php echo $numItem; ?> خدمات
								 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>

							<div class="panel-body">
								<ul class="list-unstyled latest-users">
								<?php
									if(!empty($latestItems)){
									foreach ($latestItems as $item){
										echo '<li>';
											echo  $item['Name'];
											echo  '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] .'" <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> '.lang('edit').'</span> </a> ';
											
											if($item['Approve'] == 0){
								
												echo " <a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info pull-right'> <i class='fa fa-check'></i> ".lang('activate')." </a> ";
								
												} 
										echo '</li>';
			}}else{
				echo "There's No Items To Show";
			}					?>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<!--start latest comments -->
				<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comment-o"></i>
								 آخر <?php echo $numComment; ?> تعليقات
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>

							<div class="panel-body">
								<?php

									$stmt = $conn->prepare("SELECT 
                                            						comments.*,users.Username AS User_Name  
															FROM 
																	comments
															INNER JOIN
																	users
															ON
																users.UserID = comments.User_ID
															ORDER BY
																c_id DESC
															LIMIT 
																$numComment ");

									$stmt->execute();

									$comments = $stmt->fetchAll();

									if(!empty($comments)){
									foreach($comments as $comment){
										echo "<div class='comment-box'>";
										echo '<span class="user-n"><a href="members.php?do=Edit&userid='.$comment['User_ID'].'">' . $comment['User_Name'] . '</a></span>';
										echo '<p class="user-c">' . $comment['comment'] . '</p>';
										echo "</div>";
									}
									}else{
										echo "There's No Comments To Show";
									}
								?>
							</div>
						</div>
					</div>

				

				</div>
				<!--end latest comments -->
			</div>
		</div>

		<?php
		
		include $tpl . "footer.php";


	

	}else{

		echo "<divfg class='alert alert-danger'> You can't Browse this Page Directly </div>";
		header('REFRESH:3;index.php');
		exit();
	}
	
	ob_end_flush();
?>