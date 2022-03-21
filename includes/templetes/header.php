<!DOCTYPE html>
<html dir="rtl">
	<head>
		<meta charset="UTF-8">
    <title> <?php echo getTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" size="16 * 16" href="Cpanel/upload/img/earth.ico" />
		<link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css">
		<link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css">
		<link rel="stylesheet" href="<?php echo $css;?>front-style.css">
    <link rel="stylesheet" href="<?php echo $css;?>media.css">
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap-tagsinput.css">
    <script src="<?php echo $js;?>jquery-2.2.4.min.js"></script>

    <!--[if lt IE 9]>
      <script src="<?php echo $js;?>html5shiv.min.js"></script>
      <script src="<?php echo $js;?>respond.min.js"></script>		
		<![endif]-->

	</head>
	<body> <!-- style="" onload="ajax();"  style="background:url('a.jpg') no-repeat;background-size:cover" -->
    <?php if(!(getTitle() == 'login')) { ?>
    <div class="upper-bar">
      <div class="container">
        
        <?php
            if( isset($_SESSION['user'] )){?>
                  <!-- <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /> -->
                  <?php
                  echo "<div class='row'>";
                  echo "<div class='col-6'>";
                      $u = getUser('where Username="' . $_SESSION['user'].'"');
                      //profile.php
                    echo "<a href='profile.php'> <div class='pull-left'>";
                    
                    // echo "<span style='font-weight:bold'>".$sessionUser." </span>";
                    // count the notifications for this seller
                    $noti = $conn->prepare("select status from notification where seller=".$_SESSION['uid'] . " and status = 1");
                    $noti->execute();
                    
                    $notif = ($noti->rowCount() != 0)? $noti->rowCount() : '';
                    
                    if(!empty($u['avatar'])){
                      
                      echo "<img src='Cpanel/upload/avatar/" . $u['avatar'] . "'class='my-img img-circle img-thumbnail' alt='User' /><a  id='nooot' href='notification.php?user=".$_SESSION['uid']."'><sup  style='font-size:1.2em;font-weight:bold;padding:1px'><span id='n' class='label label-danger'>". $notif."</span></sup><i  class='fa fa-bell' style='font-size:2em'></i></a>";
                      
                    }else{
                        ?> <img src='avatar.png' class='my-img img-circle img-thumbnail' alt='User' /><?php echo "<a  id='nooot' href='notification.php?user=".$_SESSION['uid']."'><sup  style='font-size:1.2em;font-weight:bold;padding:1px'><span id='n' class='label label-danger'>". $notif."</span></sup><i  class='fa fa-bell' style='font-size:2em'></i></a>";
                      }
                      
                    

                    
                  
                echo " </div></a>";
                echo "</div>";
                // right part for header
                    echo "<div class='col-6'>";
                // function for showing unread messages
                $notification = count_unseen_messages($_SESSION['user_id'],$conn);
                  ?>
                  <div class='btn btn-group my-info pull-right' style="padding:0">
                      <span><a href='chating.php'><sup id='noti' style='font-size:1.9em;font-weight:bold;padding:1px'><?php ?></sup><i class='fa fa-envelope' style='font-size:3em'></i></a></span>
 


                    <span style="margin-right:5px"class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                        <?php echo "<span style='font-weight:bold'><bdi>". $sessionUser ."</bdi></span>"?>
                        <span class='caret'></span>
                    </span>
                      <ul class='dropdown-menu '>
                        <li><a href="profile.php"><?php echo lang('PROFILE')?></a></li>
                        <li><a href="NewAd.php"><?php echo lang('add_service')?></a></li>
                        <li><a href="profile.php?#Ads"><?php echo lang('services')?></a></li>
                        <li><a href="balance.php"><?php echo lang('balance')?></a></li>
                        <li><a href="logout.php"><?php echo lang('Logout')?></a></li>
                      </ul>

                  </div>
      </div>
              <?Php
                // echo "Welcome " . $sessionUser;
              
                // echo " <a href='profile.php'>My Profile</a> "; 

                //  echo " - <a href='NewAd.php'>New item</a>"; 
                //  echo " - <a href='logout.php'>Logout</a>";
                $Ustatus  = checkUserStatus($sessionUser);
                if($Ustatus == 1){
                  echo " You Need Activate From Admin ";
                }
                
            }else{
              $s = getTitle();
              if($s == 'login'){echo "";}else{
          ?>
            <a href="login.php" class="pull-right kufi"><?php echo lang('login')?> | <?php echo lang('signup')?></a>
   
        <?php }}?>
      </div>
    </div>
              <?php }?>

	<nav class="navbar navbar-inverse" id='nav'>
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header navbar-right">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo lang('home')?></a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
    <form class="navbar-form navbar-left" action="search.php" method="GET">
          <div class="form-group">

              <!-- Search input field -->


                
          <div id="suggests" style="z-index:9999;"></div>
          <input type="search" list="searches" name="search" onkeyup="searchSuggests(this.value)" class="form-control search" style="" placeholder="البحث..." />
            <datalist id="searches">
            <option value="">
              <!-- <option value="كتابة وترجمة">
              <option value="تصميم">
              <option value="برمجة و تطوير">  
              <option value="تدريب"> -->
           </datalist>
           
          <button type="submit" class="btn btn-default btn-sm"> <i class="fa fa-search"> </i></button>
          </div>
        </form>
        <script>
              
                function searchSuggests(str){
                  $.ajax({
                    method:'GET',
                    url:'searchSuggest.php?s='+str,
                    success:function(data){;$('#searches option').val(data); console.log(data);}
                  });
                }

                </script>
      <ul class="nav navbar-nav navbar-left">
    
      <li>
        
      </li>
    
      <li><a href="ordering.php">طلبات الخدمة غير الموجودة </a></li>
      <li onclick="document.getElementById('id01').style.display='block'"><a href="#">عن الموقع</a></li>
      
     
    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">الخدمات <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  <?php
        $all = getAllFrom('*', 'categories', 'where parent = 0', '', 'ID', 'ASC');
     
        foreach($all as $cat){ 
          echo "<li><a href='categories.php?pageid=" .
           $cat['ID']  . "'>" .
            $cat['Name'] . "</a></li>";
            
        }
      ?>
                    
                    
                  </ul>
                </li>
      </ul>
      
    </div>

  </div>
</nav>


<div id="id01" class="modal">
        
  <div class="modal-content animate">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <?php $min = getOneFrom('min_price', 'settings', 'where id=1')['min_price']; ?>
      <div class="container text-center">
        <div class="row">
          <h1 class="about" style="margin-top:10%">
          <!-- <img src="Cpanel/upload/items/380_00.jpg" style="border-radius:22%;width:20%; max-height:20%"/>
          <span style="font-size:30px">
          بسم الله الرحمن الرحيم
          </span>
          <img src="Cpanel/upload/items/380_00.jpg" style="border-radius:22%;width:20%; max-height:20%"/> -->
          تقوم فكرة الموقع على تقديم خدمات مصغرة تبلغ قيمتها بداية من <?php echo $min?> جنيه سوداني مع إمكانية زيادة المبلغ حسب الإتفاق بين مُقدِم الخدمة  و العميل ، علماً أن جميع المحادثات تحت مراقبة إدارة الموقع
          </h1>
        </div>
      </div>


  </div>
    
  </div>
<!-- </div> -->






<div id="scroll-top">
            <i class="fa fa-chevron-up fa-3x"></i>
</div>



<script>


// navbar fiexed

  let n = document.getElementById('nav');
window.onscroll= function(){
	       if (window.pageYOffset >= 85){
			//    display the scroll to top button
				n.classList.add('navbar-fixed-top');
			// console.log(this.pageYOffset);
			}else{
				n.classList.remove('navbar-fixed-top');
			}
};





// About Us


// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

 <!-- axaj for getting notifications -->
<script>

// $(function() {

// $('#nooot').click(function() {

 
//     var uid=<?php //echo (isset($_SESSION['uid']))? $_SESSION['uid'] : 0; ?>;
//   $.ajax({
//                     method:'POST',
//                     url:'clear.php',
//                     data:{uid},
//                     success:function(data){ if(data != 0) {console.log('done')}; }
//                     ,error:function(one,two,three){console.log(three);}
//           });
                



// });

// //  noti();
// //   function noti(){
// //     var uid=<?php //echo (isset($_SESSION['uid']))? $_SESSION['uid'] : 0; ?>;
// //   $.ajax({
// //                     method:'POST',
// //                     url:'n.php',
// //                     data:{uid},
// //                     success:function(data){console.log(data); if(data != 0) {$('#n').html(data)}; }
// //                   });
                

// // }


// });




</script>