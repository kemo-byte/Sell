<?php
    ob_start();

    session_start();
    $pageTitle = "login";  

    if( isset($_SESSION['user'] )){
        header('location: index.php');
    }

    include "init.php";

    // check if the user comming from Http Request

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

            $user = trim($_POST['username']);
            $pass = trim($_POST['password']);
            $hashedPass = trim(sha1($pass));

            // check if the user exists in the database
           
            $stmt = $conn ->prepare("SELECT 
                                        UserID,username,password,RegStatus
                                    FROM 
                                        users 
                                    WHERE 
                                        username = ?
                                    AND 
                                        password = ? ");

            $stmt->execute(array($user,$hashedPass));
            $get = $stmt ->fetch();

            $count = $stmt ->rowCount();

            // if count > 0    username found
            
            if($count > 0 && $get['RegStatus'] == 1){
                $_SESSION['user'] = $user;	// register username
                $_SESSION['uid']  = $get['UserID']; // register user id
                $_SESSION['login_details_id'] = $conn->lastInsertId(); // register login details id
               
                
            // register activity of the user - online


            $query = "
            SELECT * FROM users 
             WHERE Username = :username
          ";
          $statement = $conn->prepare($query);
          $statement->execute(
             array(
               ':username' => $user
              )
           );
           $count = $statement->rowCount();
          
           $result = $statement->fetchAll();
             foreach($result as $row)
             {
               if($hashedPass == $row['Password']){
               {
                    $_SESSION['user_id'] = $row['UserID'];
                    $_SESSION['online'] = $row['Username'];
                    $sub_query = "
                    INSERT INTO login_details 
                    (user_id) 
                    VALUES ('".$row['UserID']."')
                    ";
                    $statement = $conn->prepare($sub_query);
                    $statement->execute();
                    $_SESSION['login_details_id'] = $conn->lastInsertId();
               }
            }
        }
                
                header('location:index.php');
                exit();
            }elseif($count > 0 && $get['RegStatus'] == 0){
                echo "<div class='alert alert-danger text-center msg'>عذراً لم يتم الموافقة على الطلب من قبل الإدارة</div>";
            }else{
                echo "<div class='alert alert-danger text-center msg'>عذراً خطأ في الإسم أو كلمة المرور</div>";
            }
        }else{
            $formErrors = array();

            $username   = trim($_POST['username']);
            $password   = trim($_POST['password']);
            $password2  = trim($_POST['confirm-password']);
            $email      = trim($_POST['email']);

            if(isset($username)){

                $filtered = filter_var($username, FILTER_SANITIZE_STRING);

                if(strlen($filtered) < 4){
                    $formErrors[] = "إسم المستخدم يجب أن يتكون بأكثر من 4 حروف";
                }
            }

            if(isset($password) && isset($password2)){
                
                if(empty($password)){

                    $formErrors[] = "لاتستخدم المسافات في كلمة المرور";
                }
           
                if(sha1($password) !== sha1($password2)){

                    $formErrors[] = "كلمة المرور غير متطابقة";
                
                }
            }

            if(isset($email)){

                $filteredEmail = filter_var($email,FILTER_SANITIZE_EMAIL);

                if(filter_var($filteredEmail,FILTER_VALIDATE_EMAIL) != TRUE){

                    $formErrors[] = "هذا البريد الإلكتروني غير صحيح";
                }

            }


            // check if there's not erros update the data

				if(empty($formErrors)){

					// check if Exists in database
				
					$check = checkItem('Username','users' , $username);

                    $one = getOneFrom('RegStatus','users','WHERE Username="aaaaa"','');


					// Insert New User Info in Database
					if($check == 0){
                        
						$stmt = $conn->prepare("INSERT INTO 
												users(Username, password , Email  ,RegStatus,  Date)
												VALUES(:zuser , :zpass , :zmail  , 0 , now()) ");
						$stmt->execute(array(
							'zuser' => $username,
							'zpass' => sha1($password),
							'zmail' => $email
						));

                        $successMsg = "بإنتظار قبول الطلب ";
					}elseif($check != 0 && $one['RegStatus'] == 0){
                        $formErrors [] = " عذراً هذا الإسم مسجل مسبقاً";
                        echo '<script>alert("هذا الإسم بإنتظار موافقة الإدارة ");</script>';
                    }else{
                        
						$formErrors [] = "عذراً هذا الإسم مسجل مسبقاً";

						//redirectHome($theMsg, 'back');
					}
                }
        }
	}
?>
    <!-- <script>alert("إضغط على تسجيل للتسجيل في الموقع !");</script> -->
    <div class="container login-page" style="margin-bottom:190px">
    <div id="m" ></div>
            <h1 class="text-center">
            <span class="selected" data-class="login"><?php echo lang('enter')?></span> | <span data-class="signup"><?php echo lang('register')?></span>
            </h1>
            
            <!--start from login-->
            <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <div class="form-container">
                    <input
                        type="text" 
                        class="form-control" 
                        name="username" 
                        autocomplete="off"
                        placeholder="إسم المستخدم"
                        required 
                        value="<?php //echo $_COOKIE['user'];?>"
                        />
                </div>
                <div class="form-container">
                    <input 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        id="loginpassword"
                        autocomplete="new-password"
                        placeholder="كلمة المرور"
                        required />
                    <input
                        type="checkbox"
                        id="check"
                        
                        /> <span>عرض كلمة المرور</span> 
                        <span><a href="forgetPassword.php">هل نسيت كلمة المرور؟</a></span>
                        
                </div>

                <input type="submit"name="login" class="btn btn-primary btn-block" value="<?php echo lang('enter')?>">
            </form>
            <!--end form login-->

            <!--start form SignUp-->
            <form class="signup"  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <div class="form-container">
                    <input
                        pattern=".{4,}"
                        title="username must be more than 4 chars"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        autocomplete="off"
                        placeholder="إسم المستخدم"
                        required />
                </div>
                <div class="form-container">
                    <input 
                        minlength="4"
                        type="password" 
                        class="form-control" 
                        name="password" 
                        autocomplete="new-password"
                        placeholder="كلمة المرور"
                        required />
                </div>
                <div class="form-container">
                    <input 
                        minlength="4"
                        type="password" 
                        class="form-control" 
                        name="confirm-password" 
                        autocomplete="new-password"
                        placeholder="تأكيد كلمة المرور"
                        required />
                </div>
                <div class="form-container">
                    <input
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="البريد الإلكتروني"
                         />
                </div>
                <div style="font-size:1.4em">
                <input type="checkbox" required="required" /> قرأت جميع <a href="polices.php">سياسات الموقع</a>  وأوافق عليها     
                 </div>
                <input type="submit" name="signup" class="btn btn-success btn-block" value="<?php echo lang('signup')?>">
            </form>
            <!--end from SignUp-->
        </div>
        <div class="the-errors text-center">
            <?php

                if(!empty($formErrors)){
                    foreach($formErrors as $error){
                        // echo "<div class='msg'>" . $error . "</div>";
                        ?>
                        <script>
                        $('#m').html('<div style="color:red;text-align:center" class="msg"><?php echo $error ?></div>')</script>

                        <?php
                    }
                }


                if(isset($successMsg)){
                    
                    // echo "<div class='msg success' style='border-left: 5px solid lime'>". $successMsg . "</div>";
                    ?><script>
                    alert("بإنتظار موافقة الإدارة");
                    $('#m').html('<div class="msg success" style=" color:lime;text-align:center;border-left: 5px solid lime"><?php echo $successMsg ?></div>')
                </script>
                <?php
                }
            ?>
        </div>
<?php
  include $tpl . "footer.php";
  ob_end_flush();
?>