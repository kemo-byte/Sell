<?php

	/*
	=====================================================
	== 
	=====================================================
	*/
		ob_start();

		session_start();

	if( isset($_SESSION['user']) ){
		
		$pageTitle = 'الإشعارات';

		include "init.php";

        if($_SESSION['uid'] == $_GET['user']) {
            
            
            ?>
            <div class="container">

                <div class="panel panel-primary" style="margin-top:50px">
                    <div class="panel-heading" style="background-color:#8e44ad;border-color:#8e44ad;color:#fff">
                        <h3 class="panel-title">الإشعارات</h3>
                    </div>
                    <div class="panel-body text-center">
                    <?php 
                    //getAllFrom('*','items','where Approve = 1','','item_ID','DESC LIMIT 12');
                    $all = getAllFrom('*','notification','where seller = '.$_SESSION['uid'],'','id','desc');
                    $stmt2 = $conn->prepare("update  notification set status = 0 where seller=".$_SESSION['uid']);
                    $stmt2->execute();

                    foreach($all as $one) {
                    
                    ?>
                    <a href="p.php?userid=<?php echo $one['buyer'];?>">
                        <div class="alert alert-danger"><?php echo $one['message'] ?></div>
                    </a>
                    <?php
                    }
                    if(isset($one['message']) == ""){echo "لاتوجد إشعارات";}
                    ?>
                    
                    </div>
                </div>

            </div>


            <?php

        } else {
            echo 'no such id';
        }


		include $tpl . "footer.php";

	}else{

		header('location: index.php');
		exit();
	}
	ob_end_flush();
?>