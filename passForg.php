<?php
    ob_start();

    session_start();
    $pageTitle = "login";  

    if( isset($_SESSION['user'] )){
        header('location: index.php');
    }

    include "init.php";





    // Check if User Coming From A Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //---------------------
      if(isset($_POST['submit'])){

        $pass = trim($_POST['password']);
        $confirm = trim($_POST['confirm-password']);
        $hashedPass = trim(sha1($pass));
        $mail = trim($_GET['Email']);

        // check if the user exists in the database
       
        if($pass == $confirm){
          

        if(strlen($pass) < 5) {
          echo "<div class='alert alert-danger text-center' style='font-size:1.2em'>كلمة المرور اقل من المسموح به</div>";
        } else{

          $stmt = $conn->prepare('update users set password = ? where Email=?');
          $stmt->execute([$hashedPass,$mail]);
          $stmt->rowCount();
          if($stmt){
            echo "<div class='alert alert-success text-center' style='font-size:1.2em'>تم تغيير كلمة المرور بنجاح</div>";
            redirectHome("إعادة توجيه");
          } else {
            echo "<div class='alert alert-danger text-center' style='font-size:1.2em'>خطأ</div>";
          }

        }



        } else {
          echo "<div class='alert alert-danger text-center' style='font-size:1.2em'>كلمة المرور غير متطابقة</div>";
        }
      }
// ---------------------------------
    }
    ?>


<style>

.con > form input{
  width:30% !important;
  margin-right: 35%;
  margin-bottom: 20px;
  margin-top: 20px;
}

</style>

<div class="container text-center con">
<?php if(isset($success)){echo $success;} ?>
<h2> أكتب كلمة المرور الجديدة</h2>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="password" class="form-control" id="password" placeholder="" name="password" />
  <input type="password" class="form-control" id="confirm-password" placeholder="" name="confirm-password" />
  <input type="submit" style="margin-right:0" name="submit" class="btn btn-success" value="حفظ" />

</form>
</div>




<?php
  include $tpl . "footer.php";
  ob_end_flush();
?>