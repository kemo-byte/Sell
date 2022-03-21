<?php
    ob_start();

    session_start();
    $pageTitle = "login";  

    if( isset($_SESSION['user'] )){
        header('location: index.php');
    }

    include "init.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';





    // Check if User Coming From A Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Assign Variables
        $user = "kamal";
        
        $to = filter_var($_POST['forget'], FILTER_SANITIZE_EMAIL);
        // $cell = 0100894456;
        $msg  = filter_var("انسخ هذا الكود إلى الحقل وإضغط تأكيد ", FILTER_SANITIZE_STRING);
        
        // Creating Array of Errors
        $formErrors = array();
        if (strlen($user) <= 3) {
            $formErrors[] = 'Username Must Be Larger Than <strong>3</strong> Characters';
        }
        if (strlen($msg) < 10) {
            $formErrors[] = 'Message Can\'t Be Less Than <strong>10</strong> Characters'; 
        }
        
        // If No Errors Send The Email [ mail(To, Subject, Message, Headers, Parameters) ]
        
        // $headers = 'From: ' . $to . '\r\n';
        // $myEmail = 'kamalkafi12@gmail.com';
        // $subject = 'Contact Form';
        
        if (empty($formErrors)) {
            
            // mail($to, $subject, $msg, $headers);
            
            // $user = '';
            // $mail = '';
            // $cell = '';
            // $msg = '';
            


            // $one = getOneFrom('img','settings','WHERE id=1');
            $stmt = $conn->prepare('select UserID from users where Email=?');
            $stmt->execute([$to]);
            $id = $stmt->fetch()['UserID'];
            if($stmt->rowCount() > 0) {
            $code = rand(100000,999999);
            $insert_code = $conn->prepare('update users set code =? where UserID='.$id);
            $insert_code->execute([$code]);
            if($insert_code){



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'kamalkafi12@gmail.com';                     // SMTP username
    $mail->Password   = 18139639314;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($to, 'Forget Password');
    $mail->addAddress($to, '');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('kamalkafi12@gmail.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'From Sell and buy Website';
    $mail->Body    = $msg . " => " . $code;
    $mail->AltBody = '';

    $mail->send();
    // echo 'Message has been sent';
    $success = '<div class="alert alert-success">تم إرسال الرمز للبريد الإلكتوني</div>';

} catch (Exception $e) {
    $success = '<div class="alert alert-danger">خطأ</div>';
    // echo " {$mail->ErrorInfo}";
}



            //   $success = '<div class="alert alert-success">تم إرسال الرمز البريد الإلكتوني</div>';
            }
        }else {
            $success = '<div class="alert alert-danger">خطأ</div>';
          }

        } else {
          $success = '<div class="alert alert-danger">خطأ</div>';
        }
        
    }
?>
<style>

.con >input,.con form input{
  width:30% !important;
  margin-right: 35%;
  margin-bottom: 20px;
  margin-top: 20px;
}

</style>

<div class="container text-center con">
<?php if(isset($success)){echo $success;} ?>
<h2>أكتب البريد الإلكتروني</h2>

<form action="" method="post">
<input type="email"  required="required" class="form-control" id="forget" placeholder="" name="forget" />
<button type="submit" id="sendCode" class="btn btn-primary">إرسال الكود</button>
</form>

<input type="number" required="required" class="form-control" id="code" placeholder="" name="code" />
<button type="submit" id="codeConfirm" class="btn btn-success">تأكيد</button>
</div>
<br/>

<script>

function Code () {
  


}
$(function() {
$('#codeConfirm').click(function(){
  var code = $('#code').val(),codeMail=$('#forget').val();
  $.ajax({
                    method:'POST',
                    url:'confCode.php',
                    data:{code,codeMail},
                    success:function(data){console.log(data); if(data == 1){window.location = 'passForg.php?Email='+codeMail+'';}else if(data == 0){alert("أدخل الرمز الصحيح ");}else if(data == 2){alert("أدخل الرمز الصحيح ");}},
                    error:function(one,two,three){console.log(one);}
          });
              
});

});
</script>

<?php
  include $tpl . "footer.php";
  ob_end_flush();
?>
