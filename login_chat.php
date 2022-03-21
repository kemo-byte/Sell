<!--
//login.php
!-->
<?php
	ob_start();
	session_start();
	$pageTitle = "login_chat"; 
	include "init.php";



$message = '';

if(isset($_SESSION['user_id']))
{
 header('location:chating.php');
}

if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE username = :username
 ";
 $statement = $conn->prepare($query);
 $statement->execute(
    array(
      ':username' => $_POST["username"]
     )
  );
  $count = $statement->rowCount();
  if($count > 0)
 {
  $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['user_id']."')
        ";
        $statement = $conn->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $conn->lastInsertId();
        header("location:chating.php");
      }
      else
      {
       $message = "<label>Wrong Password</label>";
      }
    }
 }
 else
 {
  $message = "<label>Wrong Username</labe>";
 }
}

?>

<html>  
    <head>  
        <title>Chat Application using PHP Ajax Jquery</title>  
  <!-- <link rel="stylesheet" href="jquery/jquery-ui.css">
        <link rel="stylesheet" href="bootstrap/bootstrap.css">
  <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="jquery/jquery-ui.min.js"></script> -->
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center">Chat Application using PHP Ajax Jquery</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Chat Application Login</div>
    <div class="panel-body">
     <form method="post">
      <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter Username</label>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Enter Password</label>
       <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
       <input type="submit" name="login" class="btn btn-info" value="Login" />
      </div>
      Or
      <div class="form-group">
       <a href="register.php" class="btn btn-success" >register</a>
      </div>
     </form>
    </div>
   </div>
  </div>
  <?php
	include $tpl . "footer.php";
	ob_end_flush();
?>