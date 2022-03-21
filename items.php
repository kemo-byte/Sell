<?php
    ob_start();
    session_start();
    $pageTitle = "عرض خدمة";
    

    include "init.php";

      // check if Request of itemid is numeric & get the integer value of it

      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?  intval($_GET['itemid']) : 0;

      // select all data depend on that id
  
      $stmt = $conn->prepare("SELECT 
                                    items.*,
                                    categories.Name AS Category_Name,
                                    users.Username AS Member_Name
                                
                              FROM 
                                    items 
                              INNER JOIN 
                                    categories 
                              ON
                                  categories.ID = items.Cat_ID
                              INNER JOIN
                                  users 
                              ON 
                                  users.UserID = items.Member_ID          
                              WHERE 
                                item_ID = ?
                              AND 
                                Approve = 1");
  
      // execute the Query
  
      $stmt->execute(array($itemid));
  
      // fetch the data
  
      $item = $stmt->fetch();

      $count = $stmt->rowCount();

      if($count > 0){

   

    ?>


<script>
var i = <?php echo $_GET['itemid'];?>;
function fetch_one()
 {
  $.ajax({
   url:"fetch_one.php",
   method:"POST",
   data:{i},
   success:function(data){ console.log(data);
    $('#user_details2').html(data);
   }
  })
 }
 fetch_one();
 </script>
        <h1 class="text-center"><?php echo $item['Name']?></h1>
        <div class='container'>
          <div class="row">
            <div class="col-md-3 text-center">
              <!-- <img src='avatar.png' alt='User' /> -->
              <div style="width:100%;height:80%">
              <?php

                  if(!empty($item['Image'])){
                
                    echo "<img style='width:100%;height:200px' src='Cpanel/upload/items/" . $item['Image'] . "' alt=''  class='img-responsive img-thumbnail center-block' />";
                    }else{
                  
                      echo "<img style='width:100%;height:200px' src='Cpanel/upload/items/items.jpg' alt=''  class='img-responsive img-thumbnail center-block' />";
                    }


              ?>
              </div>
              <!-- <span >
              <a href="p.php?userid=<?php// echo $item['Member_ID'] ?>" style="font-size:50px; color:#8e44ad"><?php //echo $item['Member_Name']?></a>
              </span> -->
              <?php if(isset($_SESSION['user'])){
                if($_SESSION['user'] != $item['Member_Name']){
              
              // ordering a service
             $min = getOneFrom('min_price','settings','WHERE id=1')['min_price'];
             $max =  getOneFrom('max_price','settings','WHERE id=1')['max_price'];

             // user transactions
            $user_trans = getOneFrom('*','transactions','where buyer='.$_SESSION['uid'].' and item='.$_GET['itemid']);
                  
             
              ?>



              <div class="text-center">
              <?php if($user_trans['status'] == 0) { ?>

                <input id= "order_price" type="number" min="<?php echo $min;?>" step="10" max="<?php  echo $max?>" value="<?php  echo $min;?>" style="display:block;width:100%;margin:10px;margin-right:0" />
                
                <a class="btn btn-info" id="order" href="#">طلب الخدمة</a>
              <?php } else if($user_trans['status'] == 1) { ?>
                <a class="btn btn-danger" id="disorder"  href="#">إلغاء الخدمة</a>
                
                <a class="btn btn-success" id="doneorder"  href="#">تم التسليم</a>
              <?php } ?>
              </div>
<!--                 
              <span style="display:block">
              <a id="order" href="chat_room.php?item_id=<?php // echo $item['item_ID']?>&user=<?php // echo $item['Member_ID']?>" style="font-size:50px; color:#8e44ad">إستلام</a>
              </span>
              <span style="display:none">
              <a id="disorder" href="chat_room.php?item_id=<?php // echo $item['item_ID']?>&user=<?php //echo $item['Member_ID']?>" style="font-size:50px; color:#8e44ad">إلغاء الخدمة</a>
              </span>
 -->
                   <script>

                            // for ordering a service from the website
                            $('#order').click(
                            function (){
                            var price = $('#order_price').val() ,

                            buyer =  <?php echo $_SESSION['uid']?>,
                            seller = <?php echo $item['Member_ID']?>,
                            item = <?php echo $_GET['itemid']?>;
                            
                            var msg = "هل تريد طلب هذه الخدمة؟",conf;
                            conf = confirm(msg);


                            if(conf){
                              // console.log('yes');

                              $.ajax({
                                  method:'POST',
                                  url:'buy.php',
                                  data:{
                                  price,buyer,seller,item
                                  }, beforeSend: function() {
                                  $("#order").hide();
                                  
                                  },
                                  success:function(one,two,three){
                                    // $("#disorder").fadeIn();
                                    // $("#doneorder").fadeIn();
                                    if(one == 2){
                                      location.reload();
                                    } else if(one == 1){
                                     location.reload();
                                   }else if(one == 0){
                                    alert('رصيدك غير كافي :(');
                                    location.reload();
                            }
                            console.log(one);
                            // console.log(two);
                            // console.log(three);
                            },
                            error:function(one,two,three){

                            console.log(one);
                            console.log(two);
                            console.log(three);
                            }
                            });


                            }else{
                              console.log('noooo!');
                            }

                                                        }
                            );



                            // for disordering 


                            $('#disorder').click(
                            function (){
                            var price = <?php echo ($user_trans['price'] != "")? $user_trans['price'] : 50 ?>,

                            buyer =  <?php echo $_SESSION['uid']?>,
                            seller = <?php echo $item['Member_ID']?>,
                            item = <?php echo $_GET['itemid']?>;
                            
                            var msg1 = "هل تريد إلغاء طلب هذه الخدمة؟",conf;
                            conf = confirm(msg1);


                            if(conf){
                              // console.log('yes');

                              $.ajax({
                                  method:'POST',
                                  url:'disorder.php',
                                  data:{
                                    price,buyer,seller,item
                                  }, beforeSend: function() {
                                  // $("#disorder").hide();
                                  // $("#doneorder").hide();
                                  
                                  },
                                  success:function(one,two,three){
                                    // $("#order").fadeIn();
                                  
                                    if(one == 2){
                                     location.reload();
                                     }
                                    else if(one == 1){
                                    alert("تم إلغاء الخدمة ):");
                                    location.reload();
                                    }
                                    else if(one == 0){
                                    
                                    location.reload();
                                    }
                            console.log(one);
                            $.ajax({method:'POST',url:'halve_brokerage.php',data:{price},success:function(one){console.log('Done');}})

                            // console.log(two);
                            // console.log(three);
                            },
                            error:function(one,two,three){

                            console.log(one);
                            console.log(two);
                            console.log(three);
                            }
                            });


                            }else{
                              console.log('noooo!');
                            }

                                                        }
                            );
                            // for disordering 




                            $('#doneorder').click(
                            function (){
                            var price = <?php echo ($user_trans['price'] != "")? $user_trans['price'] : 50 ?> ,

                            buyer=  <?php echo $_SESSION['uid']?>,
                            seller = <?php echo $item['Member_ID']?>,
                            item = <?php echo $_GET['itemid']?>;
                            
                            var msg2 = "هل تسلمت العمل ؟",conf;
                            conf = confirm(msg2);


                            if(conf){
                              // console.log('yes');

                              $.ajax({
                                  method:'POST',
                                  url:'done.php',
                                  data:{
                                    price,buyer,seller,item
                                  }, beforeSend: function() {
                                  // $("#disorder").hide();
                                  // $("#doneorder").hide();
                                  
                                  },
                                  success:function(one,two,three){

                                    // $("#order").fadeIn();

                           if(one == 1){
                                    alert("تم تسليم المبلغ (:");
                                    
                                     location.reload();
                                   }else if(one == 0){
                                    location.reload();
                            }
                            console.log(one);
                            $.ajax({method:'POST',url:'brokerage.php',data:{price},success:function(one){console.log('Done');}})
                            // console.log(two);
                            // console.log(three);
                            },
                            error:function(one,two,three){

                            console.log(one);
                            console.log(two);
                            console.log(three);
                            }
                            });


                            }else{
                              console.log('noooo!');
                            }

                                                        }
                            );
                            // for ordering a service from the website


                            </script>



              <!-- <span style="display:block">
              <a href="room.php?item_id=<?php echo $item['item_ID']?>&user=<?php echo $_SESSION['user']?>" >طلب الخدمة</a>
              </span> -->

              
              <?php }}?>
              <!-- <span style="display:block">
                <a href="person.php?item_id=<?php echo $item['item_ID']?>&his_id=<?php echo $item['Member_ID']?>&my_id=<?php echo $_SESSION['uid']?>" ><?php echo lang('contact')?></a>
              </span> -->
            </div>

            <div class="col-md-9 item-info">
              <h2><?php echo $item['Name'] ?></h2>
              <p><?php echo $item['Description'] ?></p>
              
              <ul class="list-unstyled">
                <li>
                  <i class="fa fa-calendar fa-fw"></i> 
                  <span><?php echo lang('date')?> :</span><?php echo $item['Add_Date'] ?></li>
                <li>
                  <i class="fa fa-money fa-fw"></i>
                  <span><?php echo lang('price')?> :</span><?php echo "50 جنيه"; ?></li>
                <li>
                <!-- <i class="fa fa-building fa-fw"></i>
                  <span>Made in : </span><?php echo $item['Country'] ?></li>
                <li> -->
                  <i class="fa fa-tags fa-fw"></i>
                  <span><?php echo lang('category')?> :  </span><a href="categories.php?pageid=<?php echo $item['Cat_ID']?>"><?php echo $item['Category_Name']?></a></li>
                <li>
                <i class="fa fa-user fa-fw"></i>
                  <span><?php echo lang('service_provider')?> :  </span><a href="p.php?userid=<?php echo $item['Member_ID'] ?>"><?php echo $item['Member_Name']?></a></li>
                <li class='tag-items'>
                <i class="fa fa-tags fa-fw"></i>
                  <span>Tags :  </span>
                  <?php 
                      $allTags = explode(',',$item['tags']);
                      foreach($allTags as $tag){
                        $tag = str_replace(' ','',$tag);
                        if(! empty($tag)){
                        echo "<a href='tags.php?name=". strtolower($tag) ."'>".$tag."</a> | ";

                        }
                      }
                  ?>
                </li>
                <?php if(isset($_SESSION['user']) && $_SESSION['uid'] != $item['Member_ID']){ ?>
                  
              
                <li>
               
                <div class="table-responsive">
                <!-- <h4 style="text-align:center">Online User</h4> -->
                <div style="text-align:right" id="user_details2"></div>
                <div id="user_model_details"></div>
              </div>

                </li>
                <hr class="custom-hr">
            <?php } ?>
              </ul>

            </div>
          </div>
          <hr class="custom-hr">
          
          
          <?php if(isset($_SESSION['user'])){?>

            <!-- start add comment -->
            <div class="col-md-offset-3">
              <h3>إضافة تعليق</h3>
              <div class="add-comment">
                
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid='.$item['item_ID'] ?>" method="POST">
                  <textarea name="comment" class="form-control" required></textarea>
                  <input type="submit" class="btn btn-warning btn-lg" value="إرسال">
                </form>

                <?php

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                      $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                      $itemid = $item['item_ID'];
                      $userid = $_SESSION['uid'];

                      if(! empty($comment)){
                        $stmt = $conn->prepare('INSERT 
                                                  comments(comment,status,comment_date,item_ID,User_ID)
                                                VALUES
                                                (:zcomment,0,NOW(),:zitemid,:zuserid)');
                        $stmt ->execute(array(
                            "zcomment"  => $comment,
                            "zitemid"   => $itemid,
                            "zuserid"   => $userid
                        ));

                        if($stmt){
                          echo "<div class='alert alert-success' style='margin-top:10px;width:500px;text-align:center;'>  بإنتظار الموافقة </div>";
                        }
                      }else{
                        echo "<div class='alert alert-danger' style='margin-top:10px;width:500px;text-align:center;'> أكتب تعليقاً</div>";
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
                                                comments.*,
                                                users.Username AS Member_Name ,
                                                users.avatar
                                          FROM 
                                                comments 
                                          INNER JOIN
                                              users 
                                          ON 
                                              users.UserID = comments.User_ID   
                                          WHERE
                                              item_ID = ?  
                                          AND 
                                              status = 1     
                                          ORDER BY 
                                            c_id");
              
                  // execute the Query
              
                  $stmt->execute(array($item['item_ID']));
              
                  // fetch the data
              
                  $comments = $stmt->fetchAll();

                  ?>
          
            <?php

                foreach($comments as $comment){
                  ?>
                  <div class="comment-box">
                    <div class='row'>
                      <div class='col-sm-2 text-center'>
                      <?php if(!empty($comment['avatar'])){echo "<img src='Cpanel/upload/avatar/".$comment['avatar']."' class='img-responsive img-thumbnail img-circle center-block' alt='User' /> ";}else{echo "<img src='avatar.png' class='img-responsive img-thumbnail img-circle center-block' alt='User' /> ";}?>
                      
                      <?php echo $comment['Member_Name'] ?></div>
                      <div class='col-sm-10'> 
                        <p class="lead"><?php echo $comment['comment']?></p>
                      </div>
                    </div>
                  <div>
                  <hr class="custom-hr">
           <?php } ?>

          </div>
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