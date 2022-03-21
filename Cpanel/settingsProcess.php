<?php
    ob_start();
    session_start();
    $pageTitle = "Show Items";
    include "init.php";


    if(isset($_SESSION['Username'])){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $email = $_POST['settingsEmail'];
            $tel = $_POST['settingsTelephone'];
            $min = $_POST['settingsMinPrice'];
            $max = $_POST['settingsMaxPrice'];


            
            // email

            if(!empty($email))
            {
                $stmt = $conn->prepare("UPDATE settings SET email='$email' WHERE  id=1");
                $stmt->execute();
                if($stmt)
                {
                    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-success'>تم تغيير البريد الإلكتروني بنجاح</div>";
                    
                    echo "</div>";
                }else{
                    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                    redirectHome($msg, 'back');
                    echo "</div>";
                }
            }else{
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                redirectHome($msg, 'back');
                echo "</div>";
            }

            // telephone

            if(!empty($tel) && $tel != 0)
            {
                $stmt = $conn->prepare("UPDATE settings SET tel='$tel' WHERE  id=1");
                $stmt->execute();

                if($stmt)
                {
                    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-success'>تم تغيير رقم الهاتف بنجاح</div>";
                   
                    echo "</div>";
                }else{
                    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                    redirectHome($msg, 'back');
                    echo "</div>";
                }
            }else{
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                redirectHome($msg, 'back');
                echo "</div>";
            }
       
        // minimum

        if(!empty($min) && $min != 0)
        {
            $stmt = $conn->prepare("UPDATE settings SET min_price='$min' WHERE  id=1");
            $stmt->execute();

            if($stmt)
            {
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-success'>تم تغيير السعر الأدنى للخدمة بنجاح</div>";
                
                echo "</div>";
            }else{
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                redirectHome($msg, 'back');
                echo "</div>";
            }
        }else{
            $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
            redirectHome($msg, 'back');
            echo "</div>";
        }

        // maximum
        if(!empty($max) && $max != 0)
        {
            $stmt = $conn->prepare("UPDATE settings SET max_price='$max' WHERE  id=1");
            $stmt->execute();

            if($stmt)
            {
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-success'>تم تغيير السعر الأعلى للخدمة بنجاح</div>";
               
                echo "</div>";
            }else{
                $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
                redirectHome($msg, 'back');
                echo "</div>";
            }
        }else{
            $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>حدث خطأ !</div>";
            redirectHome($msg, 'back');
            echo "</div>";
        }
    }

    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-success'>تم التعديل  بنجاح</div>";
    redirectHome($msg, 'back');
    echo "</div>";
    
?>

<?php

}else{

    $msg = "<div class='container' style='margin-top:60px'><div class='alert alert-danger'>There's No Such ID Or This item need Approve</div>";
    redirectHome($msg);
    echo "</div>";
  }
include $tpl . "footer.php";

ob_end_flush();
?>