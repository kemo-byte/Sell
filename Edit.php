<?php
ob_start();
  

  session_start();
	$pageTitle = "Edit"; 
  include "init.php";
  

  if($_SERVER['REQUEST_METHOD'] == "POST") {
  				
				$id 	= $_POST['userid'];
				$user 	= $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				// password trick 

				$pass = (empty($_POST['newpassword'])) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				$formErrors = array();

				if ( strlen($user) < 4 ){

					$formErrors[] = ' Username can not be less than <strong> 4 characters </strong>';
				}

				if ( strlen($user) > 20 ){

					$formErrors[] = ' Username can not be more than <strong> 20 characters </strong>';
				}

				if (empty($user)){

					$formErrors[] = '<strong>Username</strong> can not be Empty ';
				}

				if (empty($email)){

					$formErrors[] = ' <strong>Email</strong> can not be Empty ';
				}

				if (empty($name)){

					$formErrors[] = ' <strong>Full Name</strong> can not be Empty ';
				}
		

				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">'. $error . '</div>';
				}
				// check if there's not erros update the data

				if(empty($formErrors)){


					$st = $conn ->prepare("SELECT  * FROM users WHERE Username =? AND UserID !=?");

					$st->execute(array($user,$id));

					$count = $st->rowCount();

					if($count == 1){					
						$theMsg = "<div class='alert alert-danger'>This User is Exist</div>";
						redirectHome($theMsg,'back',4);
					}else{
					// update Database with the info

					$stmt = $conn->prepare("UPDATE 	users SET Username=?, Email=? ,FullName=? , Password=? WHERE UserID=? ");
					
					// $stmt->execute(array($user, $email, $name, $id));
					
					$stmt ->execute(array($user, $email, $name , $pass, $id));
					
					// echo success message
          $_SESSION['user'] = $user;
					$theMsg = "<h2 class='alert alert-success'>" . $stmt ->rowCount() . ' تم التحديث  </h2>';
					
					redirectHome($theMsg,'back',4);
				
				}
			}else{
	
				$theMsg = "<divfg class='alert alert-danger'> لا يمكن زيارة هذه الصفحة مباشرةً </div>";
				redirectHome($theMsg);

			}

			echo "</div>";
		
  }
  
  // check if Request of userid is numeric & get the integer value of it

  $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

  // select all data depend on that id

	if(isset($_SESSION['user'])){
	
  $stmt = $conn ->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
  
  // execute the Query

  $stmt ->execute(array($userid));
  
  // fetch the data

  $row = $stmt ->fetch();

  // Row the data

  $count = $stmt ->rowCount();

  // if there is such id show the data in the form

  if($stmt ->rowCount() > 0){
    
 ?>

    <h1 class="text-center">تعديل معلومات العميل</h1>

    <div class="container">

      <form class="form-horizontal text-right" action="" method="POST">

        <input type="hidden" name="userid" value="<?php echo $userid ?>" />

        <div class="form-group form-group-lg">
          
          <div class="col-sm-10 col-md-4">
            <input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required" />
          </div>
          <label class="col-sm-2 control-label"><?php echo lang('username')?></label>
        </div>

        <div class="form-group form-group-lg">
          
          <div class="col-sm-10 col-md-4 ">
            <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>" />
            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="أترك هذا الحقل فارغاً إذا لم ترد تغيير كلمة المرور"/>
          </div>
          <label class="col-sm-2 control-label"><?php echo lang('password')?></label>
        </div>

        <div class="form-group form-group-lg">
          
          <div class="col-sm-10 col-md-4">
            <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required"/>
          </div>
          <label class="col-sm-2 control-label"><?php echo lang('email')?></label>
        </div>

        
        <div class="form-group form-group-lg">
          
          <div class="col-sm-10 col-md-4">
            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
          </div>
          <label class="col-sm-2 control-label"><?php echo lang('fullname')?></label>
        </div>

        <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="حفظ التغيرات" class="btn btn-primary btn-lg" />
          </div>
        </div>

      </form>
    </div>


  <?php

  // else show message that there is no such ID

  }else{
    echo "<div class='container'>";
    $theMsg = "<div class='alert alert-danger'> there's no such ID </div>";
    redirectHome($theMsg);
    echo "</div>";
  }

  } else{
    echo "<div class='container'>";
    $theMsg = "<div class='alert alert-danger'> there's no such ID </div>";
    redirectHome($theMsg);
    echo "</div>";
  }

  include $tpl . "footer.php";
  ob_end_flush();