<?php
	session_start();
	$pageTitle = "Chat"; 
	include "init.php";
	// $q = getUser('where Username="' . $_SESSION['user'].'"');
	if(isset($_SESSION['user'])){
		
		$item_id = $_GET['item_id'];
		
		
		$s = $conn ->prepare('SELECT * FROM items  WHERE item_id=?');
    	$s->execute(array($item_id));
		$it = $s->fetch();
		$q = getUser('where UserID="' . $it['Member_ID'].'"');
        
        if(isset($_SESSION['user'])){
        
            $stmt  = $conn->prepare("SELECT * FROM chat 
                                             INNER JOIN
                                                  users 
												
                                              ON 
                                                  users.UserID = chat.Member_ID   
												
                                              ORDER BY 
                                                id
            ");
                $stmt->execute(array());
                $rows = $stmt ->fetchAll();
            
                foreach($rows as $row){
                    if(   ((($_GET['his_id'])== $row['cu_id'] )  && ($_GET['my_id']) == $row['Member_ID']  ) || (   (($_GET['my_id'])== $row['cu_id'] )  && ($_GET['his_id']) == $row['Member_ID'])  ){
                    ?>
    
                    <div id="message" class="message">
                        <!-- <img class="message-avatar" src="images/user.png" alt=""> -->
                        <?php
						$u = getUser('where Username="' . $_SESSION['user'].'"');
						echo "<a href='profile.php'> <div class='message_content pull-left'>";
             				// echo "<span style='font-weight:bold'>".$sessionUser." </span>";
							if(!empty($row['avatar'])){
							echo "<img src='Cpanel/upload/avatar/" . $row['avatar'] . "'class='my-img img-circle img-thumbnail' alt='User' />";
							}else{
								?> <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /><?php
							}
							
                            ?>
						</div>
                        <a class="message-author" href="#"> <?php echo $row['Username'];?> </a>
                        <span class="message-date"> <?php echo $row['date'];?> </span>
						<span class="message-content"> <?php echo $row['message'];?> </span>

						<?php if($row['file'] != "none"){?>
							<a href="Cpanel/upload/chat/<?php echo $row['file'];?>" class="message-content" download style="display: block;background:brown;width: 50%;margin: auto;color:#fff;cursor: pointer;border-radius: 20px;"> <?php echo $row['file'];?> </a>
						<?php }?>
					</div>

                    <?php } ?>
                    <script>
                        // function ajax(){
						// 		$.ajax({
						// 			method:'GET',
						// 			url:'chat.php',
						// 			success:function(one,two,three){
						// 				$('#chat').html(one);
						// 			},
						// 			error:function(one,two,three){
						// 				console.log(one);
						// 				console.log(two);
						// 				console.log(three);
						// 			}
						// 			});
						// 	}
	
	
	
	
						// setInterval(function() {ajax()}, 1000);


                    </script>


                    <?php }}?>

   

</div>
<div style="background-color:white;" >
     	<div style="margin-left: 20%;" class="text-center">
			<!-- <form method="POST" action="chat_room.php"> -->
				<div></div>
				<form enctype='multipart/form-data'  method="POST">
					<input type="hidden" name="id" placeholder="" value="<?php echo $_SESSION['uid']?>" required="">
					<textarea class="form-control" style="margin-bottom:10px" name="message" placeholder=" أكتب الرسالة" required=""></textarea>
					
					<div class='form-group form-group-lg'>

						<div class='col-sm-10 col-md-9'>
							<input 
							type ='file'
							class='form-control'
							name='fi' />
						</div> 
					
					</div>
					<button id="u" type="submit" style="margin-bottom:10px" class="btn btn-warning btn-lg" name="submit">إرسال</button>
				
					
				</form>
			<!-- </form> -->
		</div>
	</div>
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['submit'])){



            $itemName = $_FILES['fi']['name'] ;
            $itemSize = $_FILES['fi']['size'];
            $itemType = $_FILES['fi']['type'] ;
           // $avatar	 = $_FILES['avatar']['error'] ;
            $itemTmp  = $_FILES['fi']['tmp_name'];
    
    
            $itemAllowedExtensions = array("jpeg","jpg","png","gif","zip","rar","doc","ppt","pptx","docx","mp4","pdf");
                   
       
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
			// 130 mb
            if($itemSize > 135315728000){
                $formErrors[] = 'الصورة أقل من <strong> حجم </strong> > 130 MB ';
            }
            if(empty($formErrors)){
                $itemImg = rand(0,100000) . '_' . $itemName;
    
                       $a =  move_uploaded_file($itemTmp,'Cpanel/upload/chat/'.$itemImg);
                         
               
					
					if($a){
						$name 		= $_POST['id'];
						$message 	= $_POST['message'];
						$member = $it['Member_ID'];
						$us=$_GET['his_id'];
						
						$stmt 		= $conn ->prepare("INSERT INTO chat(Member_ID, message, it_ID, cu_id,file) VALUES (?,?,$item_id,$us,?)");
						$run 		= $stmt->execute(array($name, $message,$itemImg));
						
					
						if($run){
							$s 		= $conn ->prepare("SELECT Username from users where UserID = ?");
							$s->execute(array($us));
							$uss = $s->fetch()['Username'];
						



											// add notifiction 
					$message = "تم إرسال ملفات من قبل ". $uss ;
					$stmt1 = $conn->prepare("insert into
															notification(buyer,seller,message,status)
															values(?,?,?,?)
															");
					$stmt1->execute( [$us,$us,$message,1] );
						
							?>
							<!-- <audio src='audio/notification.mp3' hidden='true' autoplay='true'/> -->
							<?php
						}
					} else {echo "<script>alert('upload');</script>";}
	}elseif(!empty($formErrors)){
		echo "<script>console.log('hi');</script>";
			$name	= $_POST['id'];
			$message 	= $_POST['message'];
			$member = $it['Member_ID'];
			$us=$_GET['his_id'];
			
			$stmt 		= $conn ->prepare("INSERT INTO chat(Member_ID, message, it_ID, cu_id) VALUES (?,?,$item_id,$us)");
			$run 		= $stmt->execute(array($name, $message));
			if($run){
				?>
				<!-- <audio src='audio/notification.mp3' hidden='true' autoplay='true'/> -->
				<?php
	}
	}
}
}

	
?>
	</diV>
<?php include $tpl . 'footer.php';?>
    
    
    <?php
	}else{
        header('location: index.php');
    }?>