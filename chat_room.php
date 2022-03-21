<?php
	session_start();
	$pageTitle = "Chat"; 
	include "init.php";
	// $q = getUser('where Username="' . $_SESSION['user'].'"');
	if(isset($_SESSION['user'])){

		$item_id = $_GET['item_id'];
		$user = $_GET['user'];
		
		$s = $conn ->prepare('SELECT * FROM items WHERE item_id=?');
    	$s->execute(array($item_id));
		$it = $s->fetch();
	
?>
<div class="container text-center">
    <h2> CHAT ROOM </h2>
	<div class="ibox-content">
        <div class="row">
            <div style="margin-left: 10%;" class=" col-md-10">
                <div class="chat-discussion" >
                    <div class="chat-message left" >
                        <div id ="chat"></div>
                    </div>
                </div>
            </div>
		</div>
    </div>
    <?php
    $s = $conn ->prepare('SELECT * FROM users WHERE Username=?');
    $s->execute(array($_SESSION['user']));
	$r = $s->fetch();
	
    ?>

    <div style="background-color:white;" class="row">
     	<div style="margin-left: 20%;" class="col-md-8">
			<!-- <form method="POST" action="chat_room.php"> -->
				<div></div>
				<form  method="POST">
					<input type="hidden" name="name" placeholder="" value="<?php echo $r['UserID']?>" required="">
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
// if(isset($_POST['u'])){

// 			$name = $_POST['name'];
// 			$message = $_POST['message'];
// 			$stmt = $conn ->prepare("INSERT INTO chat (Member_ID, message,it_ID) VALUES (?,?,$item_id)");
// 			$run = $stmt->execute(array($name,$message));
// 			if($run){
// 				?>
 				<!-- <audio src='audio/notification.mp3' hidden='true' autoplay='true'> -->
			<?php
// 			}
//         }
        
	}else{
        header('location: index.php');
    } 
        ?>