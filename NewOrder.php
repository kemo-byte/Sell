<?php
    ob_start();

	session_start();
	$pageTitle = "Create Order"; 
	include "init.php";
	
	if(isset($_SESSION['user'])){

	$getUser = $conn ->prepare("SELECT * FROM users WHERE Username=?");
	$getUser->execute(array($sessionUser));

    $info = $getUser->fetch();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
      
        // start New Ads 
        $formError = array();

        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $desc = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);


        if(strlen($name) < 4){
            $formError[] = "item chars must be at least 4 chars";
        }

        if(strlen($desc) < 10){
            $formError[] = "item description must be at least 10 chars";
        }

       
        if(empty($category)){
            $formError[] = "item category is Not Selected";
        }

        

                
        if(empty($formErrors)){

            
            // Insert New User Info in Database
                $stmt = $conn->prepare("INSERT INTO 
                        ordering (order_name, Description , Cat_ID , Member_ID)
                        VALUES(:zname , :zdesc , :zcat , :zmember)");
                $stmt->execute(array(
                    'zname' 	=> $name,
                    'zdesc' 	=> $desc,
                    'zcat'		=> $category,
                    'zmember' 	=> $_SESSION['uid']
                ));
            
              
            // echo success message
            
            if($stmt){
                $successMsg = "تم إضافة الطلب ...";
            }
    }else{
        foreach($formErrors as $error){

            echo '<div class="alert alert-danger">'. $error . '</div>';
        }
    }


}
?>
<h1 class="text-center">طلب خدمة غير موجودة</h1>

<div class="create-ad  block">
	<div class="container">
		<div class="panel panel-warning">
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff">إضافة طلب جديد</div>
			<div class="panel-body">
                <div class="row">
               
            
            <!-- input fields of add -->
                    <div class="col-md-12">
                        <form class="form-horizontal main-form" enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <!--start name field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label"><?php //echo lang('name')?></label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text"
                                        pattern=".{4,}"
                                        title = " Must Be More than 4 chars"
                                        name="name"
                                        class="form-control live" 
                                        required="required" 
                                        placeholder="إسم الخدمة"
                                        data-class=".live-name" />
                                </div>
                            </div>
                        <!--end name field-->
                        <!--start Description field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label"><?php // echo lang('description')?></label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" 
                                        pattern=".{10,}"
                                        title = " Must Be More than 10 chars"
                                        name="description" 
                                        value="" 
                                        class="form-control live" 
                                        required="required" 
                                        placeholder="أوصف الخدمة التي تريد بكلمات واضحة"
                                        data-class=".live-desc"
                                         />
                                </div>
                            </div>
                        <!--end Description field-->

                       
                        <!--start Categories field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label"><?php echo lang('category')?></label>
                                <div class="col-sm-10 col-md-9">
                                    <select class="" name="category">
                                        <option value="">...</option>
                                        <?php
                                            $cats = getAllFrom('*','categories','','','ID');
                                           
                                            foreach($cats as $cat){

                                                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                            }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        <!--end Categories field-->

                        

                        <!--start submit field-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="إضافة خدمة" class="btn btn-warning btn-lg" />
                                </div>
                            </div>
                        <!--end submit field-->
                        </form>
                    </div>
                    
            
        </div>
        <!-- start looping through errors -->
        <?php
                            if(!empty($formError)){

                                foreach($formError as $error){
                                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                                }
                            }
                            if(isset($successMsg)){
                                echo "<div class='alert alert-success'>" . $successMsg . "</div>";
                            }
                      ?>                   
                <!-- end looping through errors -->
	</div>
    </div>
</div>
</div>

<?php

	}else{

		header('location: login.php');
		exit();
    }

    include $tpl . "footer.php";
    ob_end_flush();
?>