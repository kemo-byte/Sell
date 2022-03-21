<?php
    ob_start();
    session_start();
    $pageTitle = "Show Items";
    include "init.php";

      // check if Request of itemid is numeric & get the integer value of it

      $orderid = isset($_GET['order_id']) && is_numeric($_GET['order_id']) ?  intval($_GET['order_id']) : 0;

      // select all data depend on that id
  
      $stmt = $conn->prepare("SELECT 
                                    ordering.*,
                                    categories.Name AS Category_Name,
                                    users.Username AS Member_Name
                                
                              FROM 
                                    ordering 
                              INNER JOIN 
                                    categories 
                              ON
                                  categories.ID = ordering.Cat_ID
                              INNER JOIN
                                  users 
                              ON 
                                  users.UserID = ordering.Member_ID          
                              WHERE 
                                order_ID = ?
                              AND 
                                Approve = 1");
  
      // execute the Query
  
      $stmt->execute(array($orderid));
  
      // fetch the data
  
      $order = $stmt->fetch();

      $count = $stmt->rowCount();

      if($count > 0){

    

    ?>

        <h1 class="text-center"><?php echo $order['order_name']?></h1>
        <div class='container'>
          <div class="row">
            <div class="col-md-3 text-center">
              <!-- <img src='avatar.png' alt='User' /> -->

              <?php

               

              ?>
            
            </div>

            <div class="col-md-9 item-info">
              <h2><?php echo $order['order_name'] ?></h2>
              <p><?php echo $order['Description'] ?></p>
              

            </div>
          </div>
          <hr class="custom-hr">
          <div class="text-left">
            <button class="btn btn-success" onclick="location.reload('')">Refresh</button>
          </div>
          <?php if(isset($_SESSION['user'])){?>

            <!-- start add comment -->
            <div class="col-md-offset-3">
              <h3>تعليق</h3>
              <div class="add-comment">
                
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?order_id='.$order['order_ID'] ?>" method="POST">
                  <textarea name="comment" class="form-control" required></textarea>
                  <input type="submit" class="btn btn-warning" value="إرسال">
                </form>

                <?php

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                      $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                      $orderid = $order['order_ID'];
                      $userid = $_SESSION['uid'];

                      if(! empty($comment)){
                        $stmt = $conn->prepare('INSERT 
                                                  order_comments(comment,Order_ID,UID)
                                                VALUES
                                                (:zcomment,:zorderid,:zuserid)');
                        $stmt ->execute(array(
                            "zcomment"  => $comment,
                            "zorderid"   => $orderid,
                            "zuserid"   => $userid
                        ));

                        if($stmt){
                          echo "";
                        }
                      }else{
                        echo "<div class='alert alert-danger' style='margin-top:10px;width:500px;text-align:center;'> Type a comment</div>";
                      }
                    }


                ?>
          </div>
      
      </div>
      <?php }else{
              echo "<a href='login.php'>".lang('login')."</a>  او <a href='login.php'> ".lang('register')." </a> لإضافة تعليق";
      }?>
        <!-- end add comment -->
      <hr class="custom-hr">
        <div class="row">
        <?php
                  $stmt = $conn->prepare("SELECT 
                                                order_comments.*,
                                                users.Username AS Member_Name ,
                                                users.avatar AS a
                                          FROM 
                                            order_comments 
                                          INNER JOIN
                                              users 
                                          ON 
                                              users.UserID = order_comments.UID   
                                          WHERE
                                              order_ID = ?  
                                          AND 
                                              status = 1     
                                          ORDER BY 
                                            id");
              
                  // execute the Query
              
                  $stmt->execute(array($order['order_ID']));
              
                  // fetch the data
              
                  $comments = $stmt->fetchAll();

                  ?>
          
            <?php

                foreach($comments as $comment){
                  ?>
                  <div class="comment-box">
                    <div class='row'>
                      <div class='col-sm-2 text-center'>
                      <?php if( $comment['a'] == ''){?>
                      <img src='avatar.png' class='img-responsive img-thumbnail img-circle center-block' alt='User' />  
                      <?php }else{?>
                        <img src='Cpanel/upload/avatar/<?php echo $comment['a']?>' class='img-responsive img-thumbnail img-circle center-block' alt='User' />  
                      <?php } ?>
                      <?php echo "<a href='p.php?userid=". $comment['UID']."'>".  $comment['Member_Name'] ."</a>" ?></div>
                      
                      <div class='col-sm-10'> 
                      
                        <p class="lead"><?php echo $comment['comment']?></p>
                      <?php 
                      if(isset($_SESSION['user'])){

                        $user =  $_SESSION['user'];
                      }
                        $u = getUser("WHERE Username='$user'");
                      
                      if(isset($_SESSION['user']) && ($u['GroupID'] == 1)  ){
                        ?>
                        
                        <button class='btn btn-danger ' id="<?php echo $comment['id'] ?>" data-view=<?php echo $comment['id'] ?>   >Delete</button>

                            <script>
                            $(function(){
                                
                              var de = $("#<?php echo $comment['id'] ?>").data('view');
                                $("#<?php echo $comment['id'] ?>").on('click',function(){
                                    $.ajax({
                                      method:'POST',
                                      url: 'delete_comment.php',
                                      data:{de},
                                      beforeSend:function(){
                                        $("#del").fadeOut();
                                      },
                                      success:function(one,two,three){

                                        if(one == 1){
                                          console.log("done!");
                                        }else if(one == 0){
                                          de.fadeOut();
                                        }
                                        console.log(one);
                                        console.log(two);
                                        // console.log(three);
                                        location.reload();

                                      },error:function(one,two,three){
                                        console.log(one);
                                        console.log(two);
                                        // console.log(three);
                                      }

                                    });
                                });
                            });
                            </script>
                        <?php
                      }
                      ?>
                      </div>
                    </div>
                  </div>
                  <!-- <hr class="custom-hr"> -->
           <?php } ?>

        </div>
      </div>
      </div>
    </div>
<?php
      }else{

        $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>There's No Such ID Or This item need Approve</div>";
        redirectHome($msg);
        echo "</div>";
      }
    include $tpl . "footer.php";
  
    ob_end_flush();
?>