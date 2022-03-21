<?php
    session_start();

    include 'Cpanel/connect.php'; 
    include 'includes/functions/functions.php';

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

        <?php }
    }





