<?php

	/*
	=====================================================
	== manage comments page
	== You can Edit | Delete comments form  here
	=====================================================
	*/
		session_start();

	if( isset($_SESSION['Username']) ){
		
		$pageTitle = 'Comments';

		include "init.php";
		
		$do = isset($_GET['do'])? $_GET['do'] : 'manage';

		if($do == 'manage') {	// manage Members Page

			// select all users except the admin
				
			$stmt = $conn->prepare("SELECT 
                                            comments.*,items.Name  AS Item_Name ,users.Username AS User_Name  
                                    FROM 
                                            comments
                                    INNER JOIN
                                            items
                                    ON
                                        items.item_ID = comments.item_ID
                                    INNER JOIN
                                            users
                                    ON
                                        users.UserID = comments.User_ID
									ORDER BY
										c_id DESC	
									");

			$stmt->execute();

			$rows = $stmt->fetchAll();
			if(!empty($rows)){
		 ?>

			<h1 class="text-center">إدارة التعليقات</h1>

			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID#</td>
							<td>التعليق</td>
							<td>الخدمة</td>
							<td><?php echo lang('username')?></td>
							<td><?php echo lang('register_date')?></td>
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
									echo "<td>" . $row['c_id'] . "</td>";
									echo "<td>" . $row['comment'] . "</td>";
									echo "<td>" . $row['Item_Name'] . "</td>";
									echo "<td>" . $row['User_Name'] . "</td>";
									echo "<td>" . $row['comment_date'] . "</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> ".lang('edit')."</a>
										<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i> ".lang('delete')."</a>";
								
								if($row['status'] == 0){
								
									echo " <a href='comments.php?do=Approve&comid=" .
                                     $row['c_id'] . "' class='btn btn-info'> 
                                     <i class='fa fa-check'></i> Approve </a> ";
								
										} 

										echo "</td>";
 
								echo "</tr>";
							}
						?>
						
					

					</table>
				</div>
			
			</div>
			<?php

			}else{
				echo "<div class='container'><div class='msg'>There's No Comments To Show</div></div>";
				
			}
			?>
		<?php
		
		}elseif($do == 'Edit'){ // Edit Page

			// check if Request of comid is numeric & get the integer value of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?  intval($_GET['comid']) : 0;

			// select all data depend on that id

			$stmt = $conn ->prepare("SELECT * FROM comments WHERE c_id = ?");
			
			// execute the Query

			$stmt ->execute(array($comid));
			
			// fetch the data

			$row = $stmt ->fetch();

			// Row the data

			$count = $stmt ->rowCount();

			// if there is such id show the data in the form

			if($stmt ->rowCount() > 0){
				
		 ?>

				<h1 class="text-center">تعديل تعليق</h1>

				<div class="container">

					<form class="form-horizontal" action="?do=update" method="POST">

						<input type="hidden" name="comid" value="<?php echo $comid ?>" />

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label"><?php echo lang('comment')?></label>
							<div class="col-sm-10 col-md-4">
                                <textarea class="form-control" name="comment"><?php echo $row['comment']?></textarea>
							</div>
						</div>


						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="حفظ التعليق" class="btn btn-primary btn-lg" />
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
		
			echo "<h1 class='text-center'>تحديث التعليقات</h1>";

			echo "<div class='container'>";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$comid 	= $_POST['comid'];
				$comment 	= $_POST['comment'];
				
                // update Database with the info

                $stmt = $conn->prepare("UPDATE 	comments SET comment=? WHERE c_id=? ");
                
                // $stmt->execute(array($user, $email, $name, $id));
                
                $stmt ->execute(array($comment, $comid));
                
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

			echo "<h1 class='text-center'>حذف تعليق</h1>";

			echo "<div class='container'>";

			// check if Request of userid is numeric & get the integer value of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?  intval($_GET['comid']) : 0;

			// select all data depend on that id

			$check = checkItem('c_id', 'comments' , $comid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("DELETE FROM comments Where c_id = :zid");

				$stmt ->bindParam(":zid",$comid);

				$stmt ->execute();


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Record Deleted </div>';
				redirectHome($theMsg,"back");

			}else{

				 $theMsg = "<div class='alert alert-danger' > this ID is not Exist </div>";
				 redirectHome($theMsg);
			}	

		 echo "</div>";
		
		} elseif( $do == "Approve"){

			// Approve Member Page

			echo "<h1 class='text-center'>تنشيط حساب عميل</h1>";

			echo "<div class='container'>";

			// check if Request of comid is numeric & get the integer value of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?  intval($_GET['comid']) : 0;

			// select all data depend on that id

			$check = checkItem('c_id', 'comments' , $comid);

			//if there is such id show the data in the form

			if($check > 0){
				
				$stmt = $conn ->prepare("UPDATE comments SET status = 1 WHERE c_id=?");

				$stmt ->execute(array($comid));


				$theMsg = "<div class='alert alert-success'>" . $stmt ->rowCount() . ' Comment Approved </div>';
				redirectHome($theMsg,"back");

			}else{

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

