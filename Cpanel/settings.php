<?php
    ob_start();
    session_start();
    $pageTitle = "إعدادات الموقع";
    include "init.php";


    if(isset($_SESSION['Username'])){

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $itemName = $_FILES['back']['name'] ;
            $itemSize = $_FILES['back']['size'];
            $itemType = $_FILES['back']['type'] ;
           // $avatar	 = $_FILES['avatar']['error'] ;
            $itemTmp  = $_FILES['back']['tmp_name'];
            $del =  getOneFrom('img','settings','WHERE id=1');
           
            $itemAllowedExtensions = array("jpeg","jpg","png","gif");
                   
       
            // Get avatar Extension 
    
            $avatarExtension = explode('.', $itemName);
            $avatarExtension = end($avatarExtension);
            $avatarExtension = strtolower($avatarExtension);
    
            // start New Ads 
            $formError = array();
            if (!empty($itemName) &&! in_array($avatarExtension,$itemAllowedExtensions)){
    
                $formErrors[] = 'غير مسموح بهذا <strong> الإمتداد </strong>';
            }
            if(empty($itemName)){
                $formErrors[] = 'إختر <strong> الصورة </strong> ';
            }
    
            if($itemSize > 2097152){
                $formErrors[] = 'الصورة أقل من <strong> حجم </strong> > 1 MB ';
            }
            if(empty($formErrors)){
                $itemImg = rand(0,100000) . '_' . $itemName;
    
                        move_uploaded_file($itemTmp,'upload/img/'.$itemImg);
                         
                // Insert New User Info in Database
                    $stmt = $conn->prepare("UPDATE settings SET img='$itemImg' WHERE  id=1");
                    $stmt->execute();
            
                if($stmt){
                    unlink('upload/img/'.$del['img']);
                    //echo $del;
                    $successMsg = " تم تغيير الخلفية";
                    echo '<div class="alert alert-success" style="font-size: 1.2em;font-weight: bold;text-align: center;">'. $successMsg . '</div>';
                }
        }else{
            foreach($formErrors as $error){
                $error ="حدث خطأ عند محاولة تغيير الخلفية";
                echo '<div class="alert alert-danger" style="font-size: 1.2em;font-weight: bold;text-align: center;">'. $error . '</div>';
            }
    
        }
    }
    



?>

<div class ="container" style="padding-right: 20%;padding-top: 5%;font-size:1.2em">
    <!-- start upload image -->
        <form enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style="display: inline-block;">
            <div class='form-group form-group-lg'>

                <div class='col-sm-10 col-md-9'>
                    <input 
                    type ='file'
                    class='form-control'
                    name='back' />
                </div>
                <form action="<?php $_SERVER['PHP_SELF'];?>">
                    <label class='col-sm-3 control-label'><input type="submit" value=" تعديل الخلفية" class="btn btn-warning btn-lg" /></label>
                </form>
            </div>
        </form>	

    <!-- end upload image  -->

    <!-- start Email form -->
    
    <form method="POST" id="sett" action="settingsProcess.php" style="width:50%">
        <style>#sett>input{margin-top:2%; }</style>
        <span> تغيير البريد الإلكتروني للموقع </span>
        <input type="email" class="form-control" value= "
            <?php 
                echo getOneFrom('email','settings','WHERE id=1')['email'];
            ?>
            " name="settingsEmail" required />
       
    <!-- end Email form -->

    <!-- start Telephone form -->
   
        <span> تغييررقم هاتف الموقع </span>
        <input type="Tel" class="form-control" value= "
            <?php 
                echo getOneFrom('tel','settings','WHERE id=1')['tel'];
            ?>
            " name="settingsTelephone" required />
      

    <!-- end Telephone fomr -->

    <!-- start minimum price form -->
        <span> أدنى سعر للخدمة</span>
        <input type="number" class="form-control" value= "<?php 
                echo getOneFrom('min_price','settings','WHERE id=1')['min_price'];
            ?>" name="settingsMinPrice" required />
        

    <!-- end minimum price fomr -->

    <!-- start maximum price form -->
    
        <span> أعلى سعر للخدمة </span>
        <input type="number" class="form-control" value= "<?php 
                echo getOneFrom('max_price','settings','WHERE id=1')['max_price'];?>" name="settingsMaxPrice" required />
        <input type="submit" class="btn btn-warning btn-lg" value="<?php echo lang('save'); ?>" />
    </form>

    <!-- end maximum price fomr -->
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