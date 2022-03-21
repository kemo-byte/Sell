<?php

	/*
	=====================================================
	== manage members page
	== You can Add | Edit | Delete members form  here
	=====================================================
	*/
		session_start();

	if( isset($_SESSION['Username']) ){
		
		$pageTitle = 'Members';

		include "init.php";
		
		$do = isset($_GET['do'])? $_GET['do'] : 'manage';



		$offset = isset($_GET['offset'])? $_GET['offset'] : '';

		if($do == 'manage') {	// manage Members Page

			$query = '';

			if(isset($_GET['page']) && ($_GET['page'] == 'pending'))  {

				$query = "AND RegStatus=0";
			}
			// select all users except the admin
				
			$stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC LIMIT ".$offset.",10");

			$stmt->execute();

			$rows = $stmt->fetchAll();
			if(!empty($rows)){
		 ?>

			<h1 class="text-center">العملاء</h1>

			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>ID#</td>
							<td>Avatar</td>
							<td><?php echo lang('username')?></td>
							<td><?php echo lang('email')?></td>
							<td><?php echo lang('fullname')?></td>
							<td><?php echo lang('register_date')?></td>
							<td><?php echo lang('balance')?></td>
							<td><?php echo lang('edit')?></td>
						</tr>

						<?php
						/*

						$sth = $conn->prepare("SELECT * FROM users");
							$sth->execute();

								
							print("Fetch all of the remaining rows in the result set:\n");
							$result = $sth->fetchAll();
							print_r($result);

						*/
							foreach($rows as $row){

								echo "<tr>";
									echo "<td>" . $row['UserID'] . "</td>";
									if(!empty($row['avatar'])){
									echo "<td><img src='upload/avatar/" . $row['avatar'] . "' alt='' /></td>";
									}else{
										echo "<td><img src='upload/avatar/avatar.png' alt='' />";
									}
									echo "<td>" . $row['Username'] . "</td>";
									echo "<td>" . $row['Email'] . "</td>";
									echo "<td>" . $row['FullName'] . "</td>";
									echo "<td>" . $row['Date'] . "</td>";
									echo "<td>" . $row['balance'] . " جنيه</td>";
									echo "<td>
										<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> ".lang('edit')."</a>
										<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i> ".lang('delete')."</a>";
								
								if($row['RegStatus'] == 0){
								
									echo " <a href='members.php?do=activate&userid=" . $row['UserID'] . "' class='btn btn-info'> <i class='fa fa-check'></i> ".lang('activate')." </a> ";
								
										} else if ($row['RegStatus'] == 1) {
											echo " <a href='members.php?do=deactivate&userid=" . $row['UserID'] . "' class='btn btn-warning'> <i class='fa fa-ban'></i> ".lang('deactivate')." </a> ";
										}

										echo "</td>";
 
								echo "</tr>";
							}
						?>
						
					

					</table>
				</div>
			
				<a href='members.php?do=Add&offset=0' class="btn btn-primary"><i class="fa fa-plus"></i> إضافة عميل جديد</a> <a href="members.php?offset=<?php echo $offset + 10?>"  class="btn btn-success">التالي</a> <a href="members.php?offset=<?php echo abs($offset - 10)?>"  class="btn btn-success">السابق</a>
				<!-- <button class="btn btn-warning" onclick="print()">طباعة تقرير</button> -->
			</div>
			<?php
			}else{

				echo "<div class='container'><div class='msg'>There's No Members To Show</div>";
				echo "<a href='members.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Member</a>";
				echo "</div>";
			}
			?>
		<?php
		}elseif($do == 'Add'){  // Add Members Page
			?>
				<h1 class="text-center">إضافة عميل جديد</h1>

				<div class="container">
						<!-- default enctype is | -->
						<!-- enctype='application/x-www-form-urldecoded' -->
					<form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('username')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="username" value="" class="form-control" autocomplete="off" required="required" placeholder="" />
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('password')?></label>
							<div class="col-sm-10 col-md-4 ">
								<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder=""/>
								<i class="show-pass fa fa-eye fa-2x"></i>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('email')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="email" name="email" value="" class="form-control" required="required" placeholder="" />
							</div>
						</div>

					
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('fullname')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="full" value="" class="form-control" required="required" placeholder="" />
							</div>
						</div>

						<!-- start avatar field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Avatar</label>
							<div class="col-sm-10 col-md-4">
								<input type="file" name="avatar" value="" class="form-control" required="required" placeholder="full name is appear in your profile" />
							</div>
						</div>
						<!-- end avatar field -->
						
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="إضافة" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>

				<?php

			}elseif($do == 'insert'){ // Insert Member Page

				
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				echo "<h1 class='text-center'>Insert New Member</h1>";

				echo "<div class='container'>";

				// Upload Variables 

				
				//	print_r($avatar);

				 $avatarName = $_FILES['avatar']['name'] ;
				 $avatarSize = $_FILES['avatar']['size'];
				 $avatarType = $_FILES['avatar']['type'] ;
				// $avatar	 = $_FILES['avatar']['error'] ;
				 $avatarTmp  = $_FILES['avatar']['tmp_name'];


				 $avatarAllowedExtensions = array("jpeg","jpg","png","gif");
						
			
				 // Get avatar Extension 

				$avatarExtension = explode('.', $avatarName);
				$avatarExtension = end($avatarExtension);
				$avatarExtension = strtolower($avatarExtension);

				// Get variables from the form
				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				$hashPass = sha1($_POST['password']);
				
				$formErrors = array();

				if ( strlen($user) < 4 ){

					$formErrors[] = 'Username can not be less than <strong> 4 characters </strong>';
				}

				if ( strlen($user) > 20 ){

					$formErrors[] = ' Username can not be more than <strong> 20 characters </strong>';
				}

				if (empty($user)){

					$formErrors[] = '<strong>Username</strong> can not be Empty ';
				}

				if (empty($email)){

					$formErrors[] = ' <strong>Email</strong> can not be Empty ';
				}

				if (empty($name)){

					$formErrors[] = ' <strong>Full Name</strong> can not be Empty ';
				}


				if (empty($pass)){

					$formErrors[] = ' <strong>password</strong> can not be Empty ';
				}
		
				if (!empty($avatarName) &&! in_array($avatarExtension,$avatarAllowedExtensions)){

					$formErrors[] = 'This Extension is <strong> Not Allowed </strong>';
				}

				if(empty($avatarName)){
					$formErrors[] = 'avatar is <strong> Required </strong>';
				}

				if($avatarSize > 4194304){
					$formErrors[] = 'Avatar is <strong> Too Larg </strong> > 4 MB ';
				}


				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">'. $error . '</div>';
				}

				// check if there's not erros update the data
			
				if(empty($formErrors)){
					

					$avatar = rand(0,100000) . '_' . $avatarName;

					move_uploaded_file($avatarTmp,'upload\avatar\\'.$avatar);
					
					// check if Exists in database
					$value = $user;
					$check = checkItem('Username','users' , $value);

					// Insert New User Info in Database
					if($check == 0){
						$stmt = $conn->prepare("INSERT INTO 
												users(Username, password , Email , FullName ,RegStatus,  Date, avatar)
												VALUES(:zuser , :zpass , :zmail , :zname , 1 , now() , :zavatar )");
						$stmt->execute(array(
							'zuser'		=> $user,
							'zpass'		=> $hashPass,
							'zmail' 	=> $email,
							'zname' 	=> $name ,
							'zavatar'	=> $avatar
						));
					}else{
						$theMsg = '<div class="alert alert-danger"> The Inserted username is Exists</div>';

						redirectHome($theMsg, 'back');
					}
						/*
						$stmt = $conn->prepare("INSERT INTO	users (Username,password,Email,FullName)
												VALUES (?,?,?,?)");
					
					// $stmt->execute(array($user, $email, $name, $id));
					
						$stmt ->execute(array($user, $hashPass,$email, $name));
						*/
						
					// echo success message
					
					echo "<div class='container'>";
					$theMsg = "<h2 class='alert alert-success'>" . $stmt ->rowCount() . " Record Inserted </h2>";
					redirectHome($theMsg,'back');

					echo "</div>";
					
				}
			
			}else{
				echo "<div class='container'>";

				$theMsg = "<div class='alert alert-danger'>You can't Browse this Page Directly</div>";
				redirectHome($theMsg);

				echo "</div>";
			}

			echo "</div>";
	
			}

		elseif($do == 'Edit'){ // Edit Page

			// check if Request of userid is numeric & get the integer value of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

			// select all data depend on that id

			$stmt = $conn ->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
			
			// execute the Query

			$stmt ->execute(array($userid));
			
			// fetch the data

			$row = $stmt ->fetch();

			// Row the data

			$count = $stmt ->rowCount();

			// if there is such id show the data in the form

			if($stmt ->rowCount() > 0){
				
		 ?>

				<h1 class="text-center">تعديل معلومات العميل</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=update" method="POST">

						<input type="hidden" name="userid" value="<?php echo $userid ?>" />

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('username')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('password')?></label>
							<div class="col-sm-10 col-md-4 ">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Empty if you don't want to change"/>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('email')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required"/>
							</div>
						</div>

						
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('fullname')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('balance')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="number" min="0" max="10000" name="bal" value="<?php echo $row['balance'] ?>" class="form-control" required="required"/>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="حفظ التغيرات" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>


			<?php

			// else show message that there is no such ID

			}else{
				echo "<div class='container'>";
				$theMsg = "<div class='alert alert-danger'> there's no such ID </div>";
				redirectHome($theMsg);
				echo "</div>";
			}

		}elseif($do == 'update'){ // update page
		
			echo "<h1 class='text-center'>تحديث معلومات العميل</h1>";

			echo "<div class='container'>";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$id 	= $_POST['userid'];
				$user 	= $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];
				$bal 		= $_POST['bal'];
				// password trick 

				$pass = (empty($_POST['newpassword'])) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				$formErrors = array();

				if ( strlen($user) < 4 ){

					$formErrors[] = ' Username can not be less than <strong> 4 characters </strong>';
				}

				if ( strlen($user) > 20 ){

					$formErrors[] = ' Username can not be more than <strong> 20 characters </strong>';
				}

				if (empty($user)){

					$formErrors[] = '<strong>Username</strong> can not be Empty ';
				}

				if (empty($email)){

					$formErrors[] = ' <strong>Email</strong> can not be Empty ';
				}

				if (empty($name)){

					$formErrors[] = ' <strong>Full Name</strong> can not be Empty ';
				}
				// if (empty($bal)){

				// 	$formErrors[] = ' <strong>balance</strong> can not be Empty ';
				// }
		

				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">'. $error . '</div>';
				}
				// check if there's not erros update the data

				if(empty($formErrors)){


					$st = $conn ->prepare("SELECT  * FROM users WHERE Username =? AND UserID !=?");

					$st->execute(array($user,$id));

					$count = $st->rowCount();

					if($count == 1){					
						$theMsg = "<div class='alert alert-danger'>This User is Exist</div>";
						redirectHome($theMsg,'back',4);
					}else{
					// update Database with the info

					$stmt = $conn->prepare("UPDATE 	users SET Username=?, Email=? ,FullName=?,balance=? , Password=? WHERE UserID=? ");
					
					// $stmt->execute(array($user, $email, $name, $id));
					
					$stmt ->execute(array($user, $email, $name ,$bal, $pass, $id));
					
					// echo success message

					$theMsg = "<h2 class='alert alert-success'>" . $stmt ->rowCount() . ' Record Updated </h2>';
					
					redirectHome($theMsg,'back',4);
				}
				}
			}else{
	
				$theMsg = "<divfg class='alert alert-danger'> You can't Browse this Page Directly </div>";
				redirectHome($theMsg);

			}

			echo "</div>";
		}elseif( $do == 'Delete'){

			// Delete Member Page

			echo "<h1 class='text-center'>Delete Member</h1>";

			echo "<div class='container'>";

			// check if Request of userid is numeric & get the integer value of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

			// select all data depend on that id

			$check = checkItem('userid', 'users' , $userid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("DELETE FROM users Where UserID = :zuser");

				$stmt ->bindParam(":zuser",$userid);

				$stmt ->execute();


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Deleted </div>';
				redirectHome($theMsg,'back');

			}else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg,'back');
			}	

		 echo "</div>";
		
		} elseif( $do == "activate"){

			// Activate Member Page

			echo "<h1 class='text-center'>تنشيط عضو</h1>";

			echo "<div class='container'>";

			// check if Request of userid is numeric & get the integer value of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

			// select all data depend on that id

			$check = checkItem('userid', 'users' , $userid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("UPDATE users SET RegStatus = 1 WHERE UserID=?");

				$stmt ->execute(array($userid));


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' تم التنشيط بنجاح </div>';
				redirectHome($theMsg,'back');

			}
			
			
			
			
			else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";
		}
		elseif( $do == "deactivate"){

			// Activate Member Page

			echo "<h1 class='text-center'>حظر عضو</h1>";

			echo "<div class='container'>";

			// check if Request of userid is numeric & get the integer value of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

			// select all data depend on that id

			$check = checkItem('userid', 'users' , $userid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("UPDATE users SET RegStatus = 0 WHERE UserID=?");
				$stmt1 = $conn ->prepare("UPDATE items SET Approve = 0 WHERE Member_ID=?");
				$stmt ->execute(array($userid));
				$stmt1 ->execute(array($userid));


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' تم  حظر العضو </div>';
				$theMsg = "<div class='alert alert-success'>" . $stmt1 ->rowCount() . ' تم  حظر الخدمات </div>';
				redirectHome($theMsg,'back');

			}
			
			
			
			
			else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";
		}






		include $tpl . "footer.php";

	}else{

		header('location: index.php');
		exit();
	}

