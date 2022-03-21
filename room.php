<?php
	session_start();
	$pageTitle = "Chat"; 
	include "init.php";
	// $q = getUser('where Username="' . $_SESSION['user'].'"');
	if(isset($_SESSION['user'])){

		$item_id = $_GET['item_id'];
		$user = $_GET['user'];
		
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
                    if((($_SESSION['uid'])== $row['cu_id'] )  || ($_SESSION['uid']) == $row['Member_ID']){
                    ?>
    
                    <div id="message">
                        <!-- <img class="message-avatar" src="images/user.png" alt=""> -->
                        <?php
             $u = getUser('where Username="' . $_SESSION['user'].'"');
             echo "<a href='profile.php'> <div class='pull-left'>";
             // echo "<span style='font-weight:bold'>".$sessionUser." </span>";
             if(!empty($row['avatar'])){
               echo "<img src='Cpanel/upload/avatar/" . $row['avatar'] . "'class='my-img img-circle img-thumbnail' alt='User' />";
               }else{
                 ?> <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /><?php
               }
            
                            ?>

                        <a class="message-author" href="#"> <?php echo $row['Username'];?> </a>
                        <span class="message-date"> <?php echo $row['date'];?> </span>
                        <span class="message-content"> <?php echo $row['message'];?> </span>
                    </div>

                    <?php } ?>
                    <script>
                        function ajax(){
		$.ajax({
			method:'GET',
			url:'chat.php',
			success:function(one,two,three){
				$('#chat').html(one);
			},
			error:function(one,two,three){
				console.log(one);
				console.log(two);
				console.log(three);
			}
			});
	}
	
	
	
	
	setInterval(function() {ajax()}, 1000);


                    </script>


                    <?php }}?>

    <div style="background-color:white;" class="row">
     	<div style="margin-left: 20%;" class="col-md-8">
			<!-- <form method="POST" action="chat_room.php"> -->
				<div></div>
				<form  method="POST">
					<input type="hidden" name="name" placeholder="" value="<?php echo $u['UserID']?>" required="">
					<textarea name="message" placeholder=" أكتب الرسالة" required=""></textarea>
					<button id="u" type="submit" name="submit">إرسال</button>
				</form>
			<!-- </form> -->
		</div>
	</div>

</div>

<?php


	if(isset($_POST['submit'])){

		$name 		= $_POST['name'];
		$message 	= $_POST['message'];
		$member = $it['Member_ID'];
		
        echo $_POST['name'];
		$stmt 		= $conn ->prepare("INSERT INTO chat(Member_ID, message, it_ID, cu_id) VALUES (?,?,$item_id,$member)");
		$run 		= $stmt->execute(array($name, $message));
		if($run){
			?>
			<!-- <audio src='audio/notification.mp3' hidden='true' autoplay='true'/> -->
			<?php
		}
	}



?>
<?php include $tpl . 'footer.php';?>
    
    
    <?php
	}else{
        header('location: index.php');
    }?>