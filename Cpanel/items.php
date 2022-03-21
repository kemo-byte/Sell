<?php

	/*
	=====================================================
	== manage Items page
	== You can Add | Edit | Delete members form  here
	=====================================================
	*/
		ob_start();

		session_start();

	if( isset($_SESSION['Username']) ){
		
		$pageTitle = 'Items';

		include "init.php";
		
		$do = isset($_GET['do'])? $_GET['do'] : 'manage';

		if($do == 'manage') {	// manage Items Page
				
			$stmt = $conn->prepare("SELECT items.*,
											categories.Name AS Category_Name,
											users.Username AS Member_Name 
									FROM 
											items 
									INNER JOIN 
											categories 
									ON
											categories.ID = items.Cat_ID
									INNER JOIN
											 users 
									ON 
											 users.UserID = items.Member_ID
									ORDER BY
										item_ID DESC
									");

			$stmt->execute();

			$rows = $stmt->fetchAll();
			if(!empty($rows)){
		 ?>

			<h1 class="text-center">إدارة الخدمات</h1>

			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID#</td>
							<td><?php echo lang('name')?></td>
							<td><?php echo lang('description')?></td>
							<td><?php echo lang('price')?></td>
							<td><?php echo lang('date')?></td>
							<td><?php echo lang('category')?></td>
							<td><?php echo lang('username')?></td>
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
									echo "<td>" . $row['item_ID'] . "</td>";
									echo "<td>" . $row['Name'] . "</td>";
									echo "<td>" . $row['Description'] . "</td>";
									echo "<td>" . $row['Price'] . "</td>";
									echo "<td>" . $row['Add_Date'] . "</td>";
									echo "<td>" . $row['Category_Name'] . "</td>";
									echo "<td>" . $row['Member_Name'] . "</td>";
									echo "<td>
										<a href='items.php?do=Edit&itemid=" . $row['item_ID'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> ".lang('edit')."</a>
										<a href='items.php?do=Delete&itemid=" . $row['item_ID'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i> ".lang('delete')."</a>";
								
								if($row['Approve'] == 0){
								
									echo " <a href='items.php?do=Approve&itemid=" . $row['item_ID'] .
										 "' class='btn btn-info'>
										  <i class='fa fa-check'></i> ".lang('approve')." </a> ";
								
										} 

										echo "</td>";
 
								echo "</tr>";
							}
						?>
						
					

					</table>
				</div>
			
				<a href='items.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> إضافة خدمة جديدة</a>
			</div>
			<?php
			}else{
				echo "<div class='container'><div class='msg'>There's No Items To Show</div>";
				echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>';
				echo "</div>";
			}
			?>
		<?php
		}elseif($do == 'Add'){  // Add Items Page
		
            ?>

			<h1 class="text-center">إضافة خدمة</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=insert" method="POST">
                    <!--start name field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('name')?></label>
							<div class="col-sm-10 col-md-6">
								<input type="text"
                                       name="name"
                                       value="" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="" />
							</div>
						</div>
                     <!--end name field-->
                     <!--start Description field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('description')?></label>
							<div class="col-sm-10 col-md-6">
								<input type="text" 
                                       name="description" 
                                       value="" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="" />
							</div>
						</div>
                    <!--end Description field-->

                     <!--start Price field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('price')?></label>
							<div class="col-sm-10 col-md-6">
								<input type="text" 
                                       name="price" 
                                       value="" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="" />
							</div>
						</div>
                    <!--end Price field-->

                    <!--start Country field-->
						<!-- <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" 
                                       name="country" 
                                       value="" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="" />
							</div>
						</div> -->
                    <!--end Country field-->

                     <!--start Status field-->
						<!-- <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select class="" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
							</div>
						</div> -->
                    <!--end Status field-->

					<!--start Members field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('username')?></label>
							<div class="col-sm-10 col-md-6">
								<select class="" name="member">
                                    <option value="0">...</option>
									<?php
									$all = getAllFrom('*','users','','','UserID');
										
										foreach($all as $user){

											echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
										}

									?>
                                </select>
							</div>
						</div>
                    <!--end Members field-->

					<!--start Categories field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('category')?></label>
							<div class="col-sm-10 col-md-6">
								<select class="" name="category">
                                    <option value="0">...</option>
                                    <?php
										$all = getAllFrom('*','categories','where parent = 0','','ID');

										foreach($all as $cat){

											echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
											$all = getAllFrom('*','categories','where parent = ' . $cat['ID'],'','ID');
											foreach($all as $c){
											echo "<option value='" . $c['ID'] . "'>..." . $c['Name'] . " -> child from ".$cat['Name']."</option>";
											}
										}

									?>
                                </select>
							</div>
						</div>
					<!--end Categories field-->
					
					<!-- start tags field -->
						<div class='form-group form-group-lg'>

						<label class='col-sm-2 control-label'>Tags</label>
							<div class='col-sm-10 col-md-6'>
								<input 
										type='text'
										class='form-control'
										name='tags'
										placeholder="separate tags with comma (,)" />
							</div>

						</div>


					<!-- end tags field -->

                    <!--start submit field-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
							</div>
						</div>
                    <!--end submit field-->
					</form>
				</div>
	  				    
		<?php
		}elseif($do == 'insert'){ // Insert Member Page

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				echo "<h1 class='text-center'>إضافة خدمة</h1>";

				echo "<div class='container'>";

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				// $country 	= $_POST['country'];
				// $status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];

				// form validation
				$formErrors = array();

				if ( empty($name) ){

					$formErrors[] = 'Name can\'t be <strong> Empty </strong>';
				}

				if ( empty($desc)){

					$formErrors[] = 'Description can\'t be <strong> Empty </strong>';
				}

				if (empty($price)){

					$formErrors[] = 'Price can\'t be <strong> Empty </strong>';
				}

				// if (empty($country)){

				// 	$formErrors[] = 'Country can\'t be <strong> Empty </strong>';
				// }

				// if ( $status == 0){

				// 	$formErrors[] = 'You must choose The <strong> Status </strong>';
				// }

				if ( $member == 0){

					$formErrors[] = 'You must choose The <strong> Member </strong>';
				}

				if ( $cat == 0){

					$formErrors[] = 'You must choose The <strong> Category </strong>';
				}
		

				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">'. $error . '</div>';
				}

				// check if there's not erros update the data

				if(empty($formErrors)){

				
					// Insert New User Info in Database
						$stmt = $conn->prepare("INSERT INTO 
								items (Name, Description , Price , Add_Date  , Cat_ID , Member_ID,tags)
								VALUES(:zname , :zdesc , :zprice , NOW() , :zcat , :zmember,:ztags)");
						$stmt->execute(array(
							'zname' 	=> $name,
							'zprice'	=> $price,
							'zdesc' 	=> $desc,
							'zcat'		=> $cat,
							'zmember' 	=> $member,
							'ztags'		=> $tags

						));
					
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
		}elseif($do == 'Edit'){ // Edit Page

			// check if Request of itemid is numeric & get the integer value of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?  intval($_GET['itemid']) : 0;

			// select all data depend on that id

			$stmt = $conn ->prepare("SELECT * FROM items WHERE item_ID = ?");
			
			// execute the Query

			$stmt ->execute(array($itemid));
			
			// fetch the data

			$item = $stmt ->fetch();

			// Row the data

			$count = $stmt ->rowCount();

			// if there is such id show the data in the form

			if($stmt ->rowCount() > 0){  ?>
				
				
			<h1 class="text-center">تعديل خدمة</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid?>">
                    <!--start name field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('name')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text"
                                       name="name"
                                       value="<?php echo $item['Name'];?>" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Name of The Item" />
							</div>
						</div>
                     <!--end name field-->
                     <!--start Description field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('description')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" 
                                       name="description" 
                                       value="<?php echo $item['Description'];?>"  
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Description of The Item" />
							</div>
						</div>
                    <!--end Description field-->

                     <!--start Price field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('price')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" 
                                       name="price" 
                                       value="<?php echo $item['Price'];?>"  
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Price of The Item" />
							</div>
						</div>
                    <!--end Price field-->

                    <!--start Country field-->
						<!-- <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-4">
								<input type="text" 
                                       name="country" 
                                       value="<?php echo $item['Country'];?>"  
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Country of Made" />
							</div>
						</div> -->
                    <!--end Country field-->

                     <!--start Status field-->
						<!-- <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-4">
								<select class="" name="status">
                                    <option value="1" <?php// if($item['Status'] == 1){echo 'selected';}?> >New</option> <?php //Short if($item['Status']==1){echo 'selected'}?>
                                    <option value="2" <?php //if($item['Status'] == 2){echo 'selected';}?> >Like New</option>
                                    <option value="3" <?php //if($item['Status'] == 3){echo 'selected';}?> >Used</option>
                                    <option value="4" <?php //if($item['Status'] == 4){echo 'selected';}?> >Very Old</option>
                                </select>
							</div>
						</div> -->
                    <!--end Status field-->

					<!--start Members field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('username')?></label>
							<div class="col-sm-10 col-md-4">
								<select class="" name="member">
                                    <?php
										$stmt = $conn ->prepare("SELECT * FROM users");
										$stmt ->execute();
										$users = $stmt->fetchAll();

										foreach($users as $user){

											echo "<option value='" . $user['UserID'] . "'";
											if($item['Member_ID'] == $user['UserID']){echo 'selected';} 
											echo ">" . $user['Username'] . "</option>";
										}

									?>
                                </select>
							</div>
						</div>
                    <!--end Members field-->

					<!--start Categories field-->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('category')?></label>
							<div class="col-sm-10 col-md-4">
								<select class="" name="category">
                                    <?php
										$stmt2 = $conn ->prepare("SELECT * FROM categories");
										$stmt2 ->execute();
										$cats = $stmt2->fetchAll();

										foreach($cats as $cat){

											echo "<option value='" . $cat['ID'] . "'";
											if($item['Cat_ID'] == $cat['ID']){echo 'selected';} 
											echo ">" . $cat['Name'] . "</option>";
										}

									?>
                                </select>
							</div>
						</div>
                    <!--end Categories field-->


						<div class='form-group form-group-lg'>

						<label class='col-sm-2 control-label'>Tags</label>
							<div class='col-sm-10 col-md-6'>
								<input 
										type='text'
										class='form-control'
										name='tag'
										value="<?php echo $item['tags']?>"
										placeholder="separate tags with comma (,)" />
										
							</div>

						</div>



                    <!--start submit field-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="حفظ التغيرات" class="btn btn-primary btn-lg" />
							</div>
						</div>
                    <!--end submit field-->
					</form>

				<?php
					
				// select comments
			// $stmt = $conn->prepare("SELECT 
            //                                 comments.*,users.Username AS User_Name  
            //                         FROM 
            //                                 comments
            //                         INNER JOIN
            //                                 users
            //                         ON
            //                             users.UserID = comments.User_ID
			// 						WHERE
			// 							item_ID = ?");

			// $stmt->execute(array($itemid));

			// $rows = $stmt->fetchAll();

			// if(! empty($rows)){
		 ?>

			<!-- <h1 class="text-center">Manage [ <?php //echo $item['Name']?> ] Comments</h1>

				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>comment</td>
							<td>User Name</td>
							<td>Add Date</td>
							<td>Control</td>
						</tr> -->

						<?php
						/*

						$sth = $conn->prepare("SELECT * FROM users");
							$sth->execute();

								
							print("Fetch all of the remaining rows in the result set:\n");
							$result = $sth->fetchAll();
							print_r($result);

						*/
							// foreach($rows as $row){

							// 	echo "<tr>";
							// 		echo "<td>" . $row['comment'] . "</td>";
							// 		echo "<td>" . $row['User_Name'] . "</td>";
							// 		echo "<td>" . $row['comment_date'] . "</td>";
							// 		echo "<td>
							// 			<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> Edit</a>
							// 			<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";
								
							// 	if($row['status'] == 0){
								
							// 		echo " <a href='comments.php?do=Approve&comid=" .
                            //          $row['c_id'] . "' class='btn btn-info'> 
                            //          <i class='fa fa-check'></i> Approve </a> ";
								
							// 			} 

							// 			echo "</td>";
 
							// 	echo "</tr>";
							// }
						?>
						
					

					<!-- </table>
				</div> -->
				<?php //} ?>
				<!-- </div> -->
	  				   

			<?php

			// else show message that there is no such ID

			}else{
				echo "<div class='container'>";
				$theMsg = "<div class='alert alert-danger'> there's no such ID </div>";
				redirectHome($theMsg);
				echo "</div>";
			}


		}elseif($do == 'update'){ // update page
		

			echo "<h1 class='text-center'>تحديث الخدمة </h1>";

			echo "<div class='container'>";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				// $country 	= $_POST['country'];
				// $status 	= $_POST['status'];
				$cat 		= $_POST['category'];
				$member 	= $_POST['member'];
				$tags 		= $_POST['tag'];
				

				// form validation
				$formErrors = array();

				if ( empty($name) ){

					$formErrors[] = 'Name can\'t be <strong> Empty </strong>';
				}

				if ( empty($desc)){

					$formErrors[] = 'Description can\'t be <strong> Empty </strong>';
				}

				if (empty($price)){

					$formErrors[] = 'Price can\'t be <strong> Empty </strong>';
				}

				// if (empty($country)){

				// 	$formErrors[] = 'Country can\'t be <strong> Empty </strong>';
				// }

				// if ( $status == 0){

				// 	$formErrors[] = 'You must choose The <strong> Status </strong>';
				// }

				if ( $member == 0){

					$formErrors[] = 'You must choose The <strong> Member </strong>';
				}

				if ( $cat == 0){

					$formErrors[] = 'You must choose The <strong> Category </strong>';
				}
				if ( empty($tags)){

					$formErrors[] = 'Tags can not be <strong> Empty </strong>';
				}
		

				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">'. $error . '</div>';
				}

				// check if there's not erros update the data

				if(empty($formErrors)){

					// update Database with the info

					$stmt = $conn->prepare("UPDATE
										 		items
											SET
											 	Name=?,
												Description=?,
												Price=?,
												Cat_ID=?,
												Member_ID=?,
												tags=?
											WHERE 
												item_ID=? ");
					
					// $stmt->execute(array($user, $email, $name, $id));
	
					$stmt ->execute(array($name,$desc,$price,$cat,$member,$tags,$id));
					
					// echo success message

					$theMsg = "<h2 class='alert alert-success'>" . $stmt ->rowCount() . ' Record Updated </h2>';
					
					redirectHome($theMsg,'back',4);
				}

			}else{
	
				$theMsg = "<divfg class='alert alert-danger'> You can't Browse this Page Directly </div>";
				redirectHome($theMsg);

			}

			echo "</div>";

		}elseif( $do == 'Delete'){

			// Delete Item Page

			echo "<h1 class='text-center'>Delete Item</h1>";

			echo "<div class='container'>";

			// check if Request of Item ID is numeric & get the integer value of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?  intval($_GET['itemid']) : 0;

			// select all data depend on that id

			$check = checkItem('item_ID', 'items' , $itemid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("DELETE FROM items Where item_ID = :zid");

				$stmt ->bindParam(":zid",$itemid);

				$stmt ->execute();


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Deleted </div>';
				redirectHome($theMsg,"back");

			}else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";

		} elseif( $do == "Approve"){

			// Activate Item Page

			echo "<h1 class='text-center'>Approve Item</h1>";

			echo "<div class='container'>";

			// check if Request of Item ID is numeric & get the integer value of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?  intval($_GET['itemid']) : 0;

			// select all data depend on that id

			$check = checkItem('item_ID', 'items' , $itemid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("UPDATE items SET Approve = 1 WHERE item_ID=?");

				$stmt ->execute(array($itemid));

				$s = $conn ->prepare("select * from items where item_id = ?");
				$s ->execute([$itemid]);



				$r = $s->fetch();
				
				$client = $r['Member_ID'];
				$service = $r['Name'];
				if($stmt->rowCount() > 0){
					// add notifiction 
					$message = "تم تفعيل خدمة " . $service  ;
					$stmt1 = $conn->prepare("insert into
										notification(buyer,seller,message,status)
										values(?,?,?,?)
										");
					$stmt1->execute( [$client,$client,$message,1] );
				}



				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Activated </div>';
				redirectHome($theMsg,"back");
			}


        }include $tpl . "footer.php";

	}else{

		header('location: index.php');
		exit();
	}
	ob_end_flush();
?>