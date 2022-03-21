<?php
	ob_start();
	session_start();
	$pageTitle = "Profile"; 
	include "init.php";
	
	if(isset($_SESSION['user'])){
	
	$getUser = $conn ->prepare("SELECT * FROM users WHERE Username=?");
	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();


		// avatar


 


if($_SERVER["REQUEST_METHOD"] == "POST"){

		$itemName = $_FILES['item']['name'] ;
        $itemSize = $_FILES['item']['size'];
        $itemType = $_FILES['item']['type'] ;
       // $avatar	 = $_FILES['avatar']['error'] ;
        $itemTmp  = $_FILES['item']['tmp_name'];


        $itemAllowedExtensions = array("jpeg","jpg","png","gif");
               
   
        // Get avatar Extension 

        $avatarExtension = explode('.', $itemName);
		$avatarExtension = end($avatarExtension);
		$avatarExtension = strtolower($avatarExtension);

        // start New Ads 
        $formError = array();
		if (!empty($itemName) &&! in_array($avatarExtension,$itemAllowedExtensions)){

            $formErrors[] = 'غير مسموح بهذا <strong> الإمتداد </strong>';
        }
		if(empty($itemName)){
            $formErrors[] = 'إختر <strong> الصورة </strong> ';
        }

        if($itemSize > 2097152){
            $formErrors[] = 'الصورة أكبر من <strong> حجم </strong> > 2 MB ';
		}
		if(empty($formErrors)){

            $itemImg = rand(0,100000) . '_' . $itemName;

                    move_uploaded_file($itemTmp,'Cpanel/upload/avatar/'.$itemImg);
                     
            // Insert New User Info in Database
                $stmt = $conn->prepare("UPDATE users SET avatar='$itemImg' WHERE  UserID=?");
                $stmt->execute(array($info['UserID']));
        
            if($stmt){
				$successMsg = "تم تغيير الصورة بنجاح";
				echo '<div class="alert alert-success">'. $successMsg . '</div>';
				echo '<script>alert("تم تغيير الصورة بنجاح");</script> ';
				header('location: profile.php');
				exit();
            }
    }else{
        foreach($formErrors as $error){

            echo '<div class="alert alert-danger">'. $error . '</div>';
        }

	}

}else{

}


		// avatar




?>


<h1 class="text-center"><?php echo lang('PROFILE')?></h1>

<div class="information  block">
	<div class="container">
		<div class="panel panel-warning" >
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff"><?php echo lang('information')?></div>
			<div class="panel-body">
			<?php

$u = getUser('where Username="' . $_SESSION['user'].'"');
if(!empty($u['avatar'])){
	echo "<img src='Cpanel/upload/avatar/" . $u['avatar'] . "'class='my-img img-circle img-thumbnail' alt='User' />";
	}else{
	?> <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /><?php
	}

?>
				<!-- start upload image -->
				<form enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style="display: inline-block;">
				<div class='form-group form-group-lg'>
					
					<div class='col-sm-10 col-md-9'>
						<input 
							type ='file'
							class='form-control'
							name='item' />
					</div>
					<form action="<?php $_SERVER['PHP_SELF'];?>">
					<label class='col-sm-3 control-label'><input type="submit" value=" تعديل الصورة" class="btn btn-warning " /></label>
					</form>
				</div>
				</form>	

				<!-- end upload image  -->

				<ul class="list-unstyled">
					<li>
					<i class="fa fa-unlock-alt fa-fw"></i>
					<span><?php echo lang('name')?> :</span> <?php echo $info['Username'] ; ?>
					</li>
					
					<li>
					<i class="fa fa-envelope-o fa-fw"></i>
					<span><?php echo lang('email')?> :</span> <?php echo $info['Email'] ; ?>
					</li>
					<li>
					<i class="fa fa-user fa-fw"></i>
					<span><?php echo lang('fullname')?> :</span> <?php echo $info['FullName'] ;?>
					</li>
					<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span><?php echo lang('register_date')?> :</span> <?php echo $info['Date'] ;?>
					</li>
					
				</ul>
				<a href="Edit.php?&userid=<?php echo $_SESSION['uid']?>" class="btn btn-default"><?php echo lang('edit_information')?></a>
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
					$all = getAllFrom('*','items','where Member_ID = ' . $info['UserID'] ,'','item_ID');
					 if(!empty($all)){
						echo "<div class='row'>";
						foreach(getItems('Member_ID',$info['UserID']) as $item){
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
						echo "There's No Items To Show Add <a href='NewAd.php'>New Ad</a>";
					}


					?>
				
			</div>
		</div>
	</div>
</div>

<div class="My-comments block">
	<div class="container">
		<div class="panel panel-warning">
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff"><?php echo lang('COMMENTS')?></div>
			<div class="panel-body">
				<?php 


					$all = getAllFrom('comment', 'comments', 'where  user_id =' . $info['UserID'] , '','c_id');
							
						if(!empty($all)){
							foreach($all as $comment){
								echo "<p>" . $comment['comment'] . "</p>";
							}
						}else{
							echo "There's No Comment To Show";
						}

					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

	}else{

		header('location: login.php');
		exit();
	}
	include $tpl . "footer.php";
	 ob_end_flush();
?>