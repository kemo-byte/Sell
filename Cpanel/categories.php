<?php

	/*
	===================================
	== 		Categories 	page         ==
	===================================
	*/
		ob_start();

		session_start();

	if( isset($_SESSION['Username']) ){
		
		$pageTitle = 'Categories';

		include "init.php";
		
		$do = isset($_GET['do'])? $_GET['do'] : 'manage';

		if($do == 'manage') {	// manage Members Page

			$sort = 'asc';

			$sort_array = array('asc' , 'desc');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
				$sort = $_GET['sort'];
			}

			$stmt = $conn ->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
			$stmt ->execute();

			$cats = $stmt ->fetchAll();
			if(!empty($cats)){
			?>

			<h1 class="text-center">إدارة الأصناف</h1>
			<div class="container categories">

				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> الأصناف
						<div class="option pull-right">
							<i class="fa fa-sort"></i> طريقة الترتيب : [ 
							<a class="<?php if($sort == 'asc'){echo 'active';} ?>" href="?sort=asc"> تصاعدي </a> 
							<a class="<?php if($sort == 'desc'){echo 'active';} ?>" href="?sort=desc"> تنازلي </a> ]
							<i class="fa fa-eye"></i> طريقة العرض : [ 
							<span class='active' data-view='full'>بالتفصيل </span> |
							<span data-view='classic'>العناوين فقط</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php

							foreach($cats as $cat){

								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i> ".lang('edit')." </a>";
										echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-danger btn-xs'><i class='fa fa-close'></i> ".lang('delete')." </a>";
									echo "</div>";
									echo "<h3>" . $cat['Name'] . "</h3>";
									echo "<div class='full-view'>";
										echo "<p>" ; if($cat['Description'] == ''){echo 'this is Empty';}else{echo $cat['Description'];} echo "</p>";
										if($cat['Visibility'] == 1){echo "<span class='visibility'><i class='fa fa-eye'></i> Hidden</span>";}
										if($cat['Allow_Comment'] == 1){echo "<span class='commenting'><i class='fa fa-close'></i> Comment disabled</span>";}
										if($cat['Allow_Ads'] == 1){echo "<span class='advertises'><i class='fa fa-close'></i> Ads disabled</span>";}
										echo "</div>";
										$all = getAllFrom('*', 'categories', 'where parent = '. $cat['ID'], '', 'ID', 'ASC');
										if(!empty($all)){
										echo "<h4 class='child-head'> child categroies</h4>";
										echo "<ul class='list-unstyled child-cats'>";
										foreach($all as $c){ 
										echo  "<li class='child-link'><a href='categories.php?do=Edit&catid=". $c['ID'] . "'> " . $c['Name'] . "</a> ". 
										"<a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='confirm show-delete'>Delete</a></li>";
									}
										echo "</ul>";
	
										
								}
									
								echo "</div>";
								echo "<hr />";
								}
						?>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus" ></i> <span style="font-size:20px;">إضافة صنف جديد</span> </a>
			</div>
			<?php
			}else{
				echo "<div class='container'><div class='msg'>There's No Categories To Show</div>
				<a class='add-category btn btn-primary' href='categories.php?do=Add'><i class='fa fa-plus'></i> Add New Category </a>
				</div>";

			}
			?>
			<?php
		}elseif($do == 'Add'){  // Add Members Page ?>
			

			<h1 class="text-center">إضافة صنف جديد</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=insert" method="POST">

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('name')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="name" value="" class="form-control" autocomplete="off" required="required" placeholder="" />
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('description')?></label>
							<div class="col-sm-10 col-md-4 ">
								<input type="text " name="description" class=" form-control" placeholder=""/>
								
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('ordering')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="ordering" value="" class="form-control" placeholder="" />
							</div>
						</div>
						<!-- start category type -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent ? </label>
							<div class="col-sm-10 col-md-4">
								<select name='parent'>
									<option value="0">None</option>
									<?php
										$all = getAllFrom('*','categories','where parent = 0','','ID','ASC');
										foreach($all as $cat){
											echo "<option value='".$cat['ID']."'>" . $cat['Name'] . "</option>";
										}

										?>
								</select>
							</div>
						</div>
						<!-- end category type -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" checked /> 
									<label for="vis-yes">Yes</label>
								</div>

								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" /> 
									<label for="vis-no">No</label>
								</div>

							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" checked /> 
									<label for="com-yes">Yes</label>
								</div>

								<div>
									<input id="com-no" type="radio" name="commenting" value="1" /> 
									<label for="com-no">No</label>
								</div>

							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" checked /> 
									<label for="ads-yes">Yes</label>
								</div>

								<div>
									<input id="ads-no" type="radio" name="ads" value="1" /> 
									<label for="ads-no">No</label>
								</div>

							</div>
						</div>

						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="إضافة الصنف" class="btn btn-primary btn-lg" />
							</div>
						</div>

					</form>
				</div>
	  				    
		<?php
		}elseif($do == 'insert'){ // Insert Member Page

			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				echo "<h1 class='text-center'>Insert New Category</h1>";

				echo "<div class='container'>";

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$parent		= $_POST['parent'];
				$ordering 	= $_POST['ordering'];
				$visible 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads'];

	
					// check if Category Exists in database

					$check = checkItem('Name','categories' , $name);

					// Insert New Category Info in Database
					if($check == 0){
						$stmt = $conn->prepare("INSERT INTO 
								categories(Name, Description ,parent, Ordering , Visibility ,Allow_Comment,  Allow_Ads)
									VALUES(:zname , :zdesc ,:zparent, :zorder , :zvisible ,:zcomment,:zads) ");
						$stmt->execute(array(
							'zname'		 => $name,
							'zdesc' 	 => $desc,
							'zparent'	 => $parent,
							'zorder' 	 => $ordering,
							'zvisible'	 => $visible,
							'zcomment' 	 => $comment,
							'zads'   	 => $ads 
						));
					}else{
						$theMsg = '<div class="alert alert-danger"> This Category is Exists</div>';

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
				

			}else{
				echo "<div class='container'>";

				$theMsg = "<div class='alert alert-danger'>You can't Browse this Page Directly</div>";
				redirectHome($theMsg,'back');

				echo "</div>";
			}

			echo "</div>";
		
		}elseif($do == 'Edit'){ // Edit Page

			// check if Request of catid is numeric & get the integer value of it

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?  intval($_GET['catid']) : 0;

			// select all data depend on that id

			$stmt = $conn ->prepare("SELECT * FROM categories WHERE ID = ? ");
			
			// execute the Query

			$stmt ->execute(array($catid));
			
			// fetch the data

			$cat = $stmt ->fetch();

			// Row the data

			$count = $stmt ->rowCount();

			// if there is such id show the data in the form

			if($stmt ->rowCount() > 0){ ?>
				
				<h1 class="text-center">تعديل صنف</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>" />

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('name')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="" value="<?php echo $cat['Name']?>"/>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('description')?></label>
							<div class="col-sm-10 col-md-4 ">
								<input type="text" name="description" class=" form-control" placeholder="" value="<?php echo $cat['Description']?>" />
								
							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('ordering')?></label>
							<div class="col-sm-10 col-md-4">
								<input type="text" name="ordering"  class="form-control" placeholder=""  value="<?php echo $cat['Ordering']?>"/>
							</div>
						</div>

						<!-- start category type -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent ? </label>
							<div class="col-sm-10 col-md-4">
								<select name='parent'>
									<option value="0">None</option>
									<?php
										$all = getAllFrom('*','categories','where parent = 0','','ID','ASC');
										foreach($all as $c){
											echo "<option value='".$c['ID']."'";
												if($c['ID'] == $cat['parent'])echo 'selected';
											echo ">" . $c['Name'] . "</option>";
										}

										?>
								</select>
								
							</div>
						</div>
						<!-- end category type -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) echo "checked"; ?> /> 
									<label for="vis-yes">Yes</label>
								</div>

								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) echo "checked"; ?>/> 
									<label for="vis-no">No</label>
								</div>

							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) echo "checked"; ?> /> 
									<label for="com-yes">Yes</label>
								</div>

								<div>
									<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) echo "checked"; ?>/> 
									<label for="com-no">No</label>
								</div>

							</div>
						</div>

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-4">

								<div>
									<input id="ads-yes" type="radio" name="ads" value="0"  <?php if($cat['Allow_Ads'] == 0) echo "checked"; ?>/> 
									<label for="ads-yes">Yes</label>
								</div>

								<div>
									<input id="ads-no" type="radio" name="ads" value="1"<?php if($cat['Allow_Ads'] == 1) echo "checked"; ?> /> 
									<label for="ads-no">No</label>
								</div>

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
		
		echo "<h1 class='text-center'>Update Category</h1>";

			echo "<div class='container'>";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$parent 	= $_POST['parent'];
				$visible 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads'];

			
					// update Database with the info

					$stmt = $conn->prepare("UPDATE 	categories
											 SET Name=?,
											 	 Description=?,
											 	 Ordering=?,
												 parent=?,
											 	 Visibility=?,
											 	 Allow_Comment=?,
											 	 Allow_Ads=?
											 WHERE
											 	 ID=? ");
					
					// $stmt->execute(array($user, $email, $name, $id));
					
					$stmt ->execute(array($name, $desc, $order, $parent, $visible, $comment,$ads,$id));
					
					// echo success message

					$theMsg = "<h2 class='alert alert-success'>" . $stmt ->rowCount() . ' Record Updated </h2>';
					
					redirectHome($theMsg,'back',4);
				

			}else{
	
				$theMsg = "<divfg class='alert alert-danger'> You can't Browse this Page Directly </div>";
				redirectHome($theMsg);

			}

			echo "</div>";
		}elseif( $do == 'Delete'){

			// Delete Member Page

			echo "<h1 class='text-center'>Delete Category</h1>";

			echo "<div class='container'>";

			// check if Request of catid is numeric & get the integer value of it

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?  intval($_GET['catid']) : 0;

			// select all data depend on that id

			$check = checkItem('ID', 'categories' , $catid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("DELETE FROM categories Where ID = :zid");

				$stmt ->bindParam(":zid",$catid);

				$stmt ->execute();


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Deleted </div>';
				redirectHome($theMsg,"back");

			}else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";
		
		} elseif( $do == "activate"){

			// Activate Member Page

			echo "<h1 class='text-center'>Activate Member</h1>";

			echo "<div class='container'>";

			// check if Request of userid is numeric & get the integer value of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])?  intval($_GET['userid']) : 0;

			// select all data depend on that id

			$check = checkItem('userid', 'users' , $userid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("UPDATE users SET RegStatus = 1 WHERE UserID=?");

				$stmt ->execute(array($userid));


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Activated </div>';
				redirectHome($theMsg);

			}else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";

		}elseif( $do == 'Delete'){ // Delete page


		}include $tpl . "footer.php";

	}else{

		header('location: index.php');
		exit();
	}
	ob_end_flush();
?>