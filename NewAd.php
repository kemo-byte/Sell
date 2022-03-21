<?php
	session_start();
	$pageTitle = "إضافة خدمة"; 
	include "init.php";
	
	if(isset($_SESSION['user'])){

	$getUser = $conn ->prepare("SELECT * FROM users WHERE Username=?");
	$getUser->execute(array($sessionUser));

    $info = $getUser->fetch();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $itemName = $_FILES['item']['name'] ;
        $itemSize = $_FILES['item']['size'];
        $itemType = $_FILES['item']['type'] ;
       // $avatar	 = $_FILES['avatar']['error'] ;
        $itemTmp  = $_FILES['item']['tmp_name'];


        $itemAllowedExtensions = array("jpeg","jpg","png","gif");
               
   
        // Get avatar Extension 

        $avatarExtension = explode('.', $itemName);
		$avatarExtension = end($avatarExtension);
		$avatarExtension = strtolower($avatarExtension);

        // start New Ads 
        $formError = array();

        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $desc = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        // $price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        // $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        // $status = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        $tags = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);


        if(strlen($name) < 4){
            $formError[] = "item chars must be at least 4 chars";
        }

        if(strlen($desc) < 10){
            $formError[] = "item description must be at least 10 chars";
        }

        // if(strlen($country) < 2){
        //     $formError[] = "item  country must be at least 2 chars";
        // }

        // if(empty($price)){
        //     $formError[] = "item price is Empty";
        // }

        // if(empty($status)){
        //     $formError[] = "item status is Not Selected";
        // }
        if(empty($category)){
            $formError[] = "item category is Not Selected";
        }

        if (!empty($itemName) &&! in_array($avatarExtension,$itemAllowedExtensions)){

            $formErrors[] = 'This Extension is <strong> Not Allowed </strong>';
        }

        if(empty($itemName)){
            $formErrors[] = 'avatar is <strong> Required </strong>';
        }

        if($itemSize > 4194304){
            $formErrors[] = 'Avatar is <strong> Too Larg </strong> > 4 MB ';
        }


                
        if(empty($formErrors)){

            $itemImg = rand(0,100000) . '_' . $itemName;

                    move_uploaded_file($itemTmp,'Cpanel/upload/items/'.$itemImg);
                     
            // Insert New User Info in Database
                $stmt = $conn->prepare("INSERT INTO 
                        items (Name, Description  , Add_Date, Cat_ID , Member_ID,tags,image)
                        VALUES(:zname , :zdesc , NOW() , :zcat , :zmember,:ztags,:zimg)");
                $stmt->execute(array(
                    'zname' 	=> $name,
                    // 'zprice'	=> $price,
                    'zdesc' 	=> $desc,
                    // 'zcountry'	=> $country,
                    // 'zstatus' 	=> $status,
                    'zcat'		=> $category,
                    'zmember' 	=> $_SESSION['uid'],
                    'ztags'     => $tags,
                    'zimg'      => $itemImg
                ));
            
                /*
                $stmt = $conn->prepare("INSERT INTO	users (Username,password,Email,FullName)
                                        VALUES (?,?,?,?)");
            
            // $stmt->execute(array($user, $email, $name, $id));
            
                $stmt ->execute(array($user, $hashPass,$email, $name));
                */
            // echo success message
            
            if($stmt){
                $successMsg = "بإنتظار الموافقة على الخدمة ...";
            }
    }else{
        foreach($formErrors as $error){

            echo '<div class="alert alert-danger">'. $error . '</div>';
        }
    }


}
?>
<h1 class="text-center">إضافة خدمة جديدة</h1>

<div class="create-ad  block">
	<div class="container">
		<div class="panel panel-warning">
			<div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff">إضافة خدمة جديدة</div>
			<div class="panel-body">
                <div class="row">
                <div class="col-md-4">
                        
                        <div class='thumbnail item-box live-preview'>
                            <span class="price">
                            <?php $min = getOneFrom('min_price','settings','where id=1')['min_price'];?>
                                 <span class='live-price'><?php echo $min ?></span> جنيه
                            </span>
                            <!-- <img src='avatar.png' class='img-responsive' alt='User' /> -->
                            <?php
                                    if(!empty($item['img'])){
                                        echo "<img id='previewImg' style='width:100%;height:300px;' src='" . $item['img'] . "' alt=''  class='img-responsive img-thumbnail center-block' />";
                                        }else{
                                          echo "<img id='previewImg' style='width:100%;height:300px;' src='Cpanel/upload/items/items.jpg' alt=''  class='img-responsive img-thumbnail center-block' />";
                                        }

                                    ?>
                            <div class='caption'>
                            <label style="font-size:1.1em;font-weight:bold">إسم الخدمة</label><h3 style="margin:0" class="live-name"><?php // echo lang('name')?></h3>
                            <label style="font-size:1.1em;font-weight:bold">وصف الخدمة</label><p style="margin:0;overflow:auto;word-wrap: break-word;" class="live-desc"><?php // echo lang('description')?></p>
                            <!-- <span style='font-size:12px;color: #bcb7b7;position: absolute;right: 10px;bottom:25px'>Date</span> -->
                    
                    </div>
                    <!-- <button id="previewBtn">Preview</button> -->
                    <script>


                    // function to preview image
                        function previewFile(input){
                            var file = $("input[type=file]").get(0).files[0];
                    
                            if(file){
                                var reader = new FileReader();
                    
                                reader.onload = function(){
                                    $("#previewImg").attr("src", reader.result);
                                }
                    
                                reader.readAsDataURL(file);
                            }
                        }
                    </script>
                </div>
              
            </div>

            <!-- input fields of add -->
                    <div class="col-md-8">
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
                                        placeholder="أوصف ما سوف تقوم به بكلمات واضحة"
                                        data-class=".live-desc" />
                                </div>
                            </div>
                        <!--end Description field-->

                        <!--start Price field-->
                            <!-- <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label"><?php// echo lang('price')?></label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" 
                                        name="price" 
                                        value="" 
                                        class="form-control live" 
                                        required="required" 
                                        placeholder="سعر الخدمة"
                                        data-class=".live-price" />
                                </div>
                            </div> -->
                        <!--end Price field-->

                        <!--start Country field-->
                            <!-- <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" 
                                        name="country" 
                                        value="" 
                                        class="form-control" 
                                        required="required" 
                                        placeholder="Country of Made" />
                                </div>
                            </div> -->
                        <!--end Country field-->

                        <!--start Status field-->
                            <!-- <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-10 col-md-9">
                                    <select class="" name="status">
                                        <option value="">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select>
                                </div>
                            </div> -->
                        <!--end Status field-->

                        <!--start Members field-->
                            
                        <!--end Members field-->

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

                        <!-- start tags field -->
						<div class='form-group form-group-lg'>
                            <label class='col-sm-3 control-label'>Tags</label>
                                <div class='col-sm-10 col-md-9'>
                                    <input 
                                            type='text'
                                            class='form-control'
                                            data-role='tagsinput'
                                            name='tags'
                                            placeholder="قم بفصل كل تاق بعلامة الفاصلة (,)" />
                                </div>
                            </div>
                        <!-- end tags field -->

                        <!-- start upload image -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-3 control-label'><?php echo lang('image')?></label>
                            <div class='col-sm-10 col-md-9'>
                                <input 
                                    id="service_img"
                                    type ='file'
                                    onchange="previewFile(this);" 
                                    class='form-control'
                                    name='item' />
                            </div>
                        </div>
                                    

                        <!-- end upload image  -->

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
?>