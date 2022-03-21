<?php 

	/* 
	** Get All Function v2.0
	** Funciton to get All from database
	*/

	function getAllFrom($field,$table,$where=null,$and = null, $orderField,$ordering="DESC" ){

		global $conn;
		
		$getAll = $conn->prepare("SELECT $field FROM $table  $where $and ORDER BY $orderField $ordering ");
		$getAll->execute();
		$get = $getAll->fetchAll();

		return $get;
	}


	/* 
	** Get All Function v1.0
	** Funciton to get one from database
	*/

	function getOneFrom($field,$table,$where=null,$and = null ){

		global $conn;
		
		$getAOne = $conn->prepare("SELECT $field FROM $table  $where $and");
		$getAOne->execute();
		$get = $getAOne->fetch();

		return $get;
	}


	/* 
	** Get Categories Function v1.0
	** Funciton to get Categories from database
	*/

	// function getCat(){

	// 	global $conn;

	// 	$getCat = $conn->prepare("SELECT * FROM categories ORDER BY ID ASC");
	// 	$getCat->execute();
	// 	$Cats = $getCat->fetchAll();

	// 	return $Cats;
	// }

	
	/*
	** Get Categories Function v1.0
	** Funciton to get Categories from database
	*/

	function getUser($u){

		global $conn;

		$getUser = $conn->prepare("SELECT * FROM users $u ORDER BY UserID ASC");
		$getUser->execute();
		$u = $getUser->fetch();

		return $u;
	}
/* 
	** Get Items Function v1.0
	** Funciton to get Items from database
	*/

	function getItems($M,$ID){

		global $conn;

		// if($Approve == null){
		// 	$sql = "AND Approve = 1";
		// }else{
		// 	$sql = null;
		// }
			// *********************
		// $sql = $Approve == null ? ' AND Approve =1':'';

		$getItem = $conn->prepare("SELECT * FROM items WHERE $M = ? ORDER BY $M  DESC");
		$getItem->execute(array($ID));
		$Items = $getItem->fetchAll();

		return $Items;
	}

	/* 
	** Get AD Items Function v1.0
	** Funciton to AD get Items from database
	*/

	function getItem($CatID,$Approve = null){

		global $conn;
		if($Approve == null){
			$sql = "AND Approve = 1";
		}else{
			$sql = null;
		}
		$getItem = $conn->prepare("SELECT * FROM items WHERE Cat_ID =?  $sql ORDER BY item_ID DESC");
		$getItem->execute(array($CatID));
		$Items = $getItem->fetchAll();

		return $Items;
	}

	/*
	** check user if not activated
	** function to check the RegStatus of the user
	*/

	function checkUserStatus($user){
		global $conn;
		$stmtx = $conn ->prepare("SELECT 
                                    username,RegStatus 
                                 FROM 
                                    users 
                                 WHERE 
                                    username = ?
                                 AND 
                                    RegStatus = 0 ");

		$stmtx->execute(array($user));
		$status = $stmtx ->rowCount();
		return $status;
	}

	/*
	** Title Function v1.0
	** Title function that echo the page title
	** 
	*/

	function getTitle(){

		global $pageTitle ;

		if(isset($pageTitle)){

			return $pageTitle;
		}else{

			return "default";
		}
	}

	/*
	** Home Redirect function v2.0
	** this function accept parameters
	** $theMsg = Echo message [Error , Success, warning]
	** $url = link to redirect to 
	** $seconds = seconds before redirecting
	*/

	function redirectHome($theMsg, $url = null, $seconds = 3){

		if($url === null){

			$url = 'index.php';

			$link = 'Homepage';
		
		}else{

			$url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";
				
			$link ='Pervious Page';

			// if(isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] !== '')){

			// $url = $_SERVER['HTTP_REFERER']; // indecate the page that your request is come from
			
			// }else{

			// 	$url = "index.php";
			// }
		}

		echo $theMsg;
		echo "<div class='alert alert-info'> سوف يتم تحويلك للصفحة بعد  " . $seconds . " ثواني";

		header("refresh:$seconds;$url");
		exit(); 
	}

	/*
	** check items function v1.0
	** Function to check item in database [ Function accept parameters]
	** $select = The item to select [ex : user, item,category]
	** $from = The table to select from [ex : users,item,categories]
	** $value = the value of select [ex: kamal , box , electronics]
	*/

	function checkItem($select, $from, $value){

		global $conn;

		$statement = $conn ->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement ->execute(array($value));

		$count = $statement ->rowCount();

		return $count;
	}


	/*
	** count number of items function v1.0
	** function to count number of rows
	** $item = the item to count
	** $talbe = the table to choose from
	*/

	function countItems($item , $table){

		global $conn;

		$stmt2 = $conn ->prepare("SELECT COUNT($item) FROM $table");
		$stmt2 ->execute();
		return $stmt2->fetchColumn();
	}

	/*
	** My function for activate v1.0
	** function to activate members who are pending
	** $item = the field to be activated 
	** $table = the table in the database
	** $status = the status of the item
	*/

	function activate($item , $table , $status){

		global $conn;

		$stmt = $conn -> prepare("SELECT COUNT($item) FROM $table WHERE $item = ?");

		$stmt ->execute(array($status));

		return $stmt->fetchColumn();
	}

	/* 
	** Get Latest Record Function v1.0
	** Funciton to get latest items from database [ users , items , comments]
	** $select = field to select
	** $table = the table to choose from
	** $order = the desc ordering
	** $limit = number of records to get
	*/

	function getLatest( $select , $table , $order , $limit = 5){

		global $conn;

		$getStmt = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
		$getStmt->execute();
		$rows = $getStmt->fetchAll();

		return $rows;
	}

	// chating system functions

function fetch_user_last_activity($user_id, $conn)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '$user_id' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}

function fetch_user_chat_history($from_user_id, $to_user_id, $conn)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY timestamp ASC
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  if($row["from_user_id"] == $from_user_id)
  {
   $user_name = '<b class="text-success">أنت</b>';
  }
  else
  {
   $user_name = '<b class="text-danger" >'.get_user_name($row['from_user_id'], $conn).'</b>';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc">
   <p>'.$user_name.' - '.$row["chat_message"].'
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>
  ';
 }
 $output .= '</ul>';
 $query = "
 UPDATE chat_message 
 SET status = '0' 
 WHERE from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."' 
 AND status = '1'
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 return $output;
}

function get_user_name($user_id, $conn)
{
 $query = "SELECT username FROM users WHERE UserID = '$user_id'";
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}



function count_unseen_message($from_user_id, $to_user_id, $conn)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
 
    ?>
  
  <?php
  
  $output = '<span class="label label-danger">'.$count.'</span>';
 }
 return $output;
}

function count_unseen_messages( $to_user_id, $conn)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE  to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
	 
	 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 1 hour ');
	 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
// echo "<audio id='au' src='audio/notification.mp3' hidden='true' autoplay='true'>";
	  
//   <script>

// to stop notification when played once
//   var aid = document.getElementById("au");
  
 
//  </script>

	$output = '<span class="label label-danger">'.$count.'</span>';
	// if($statement->fetch()['timestamp'] <= $current_timestamp){
	//  $output .= "<audio id='au' src='audio/notification.mp3' hidden='true' autoplay='true'>";
	// } else if($statement->fetch()['timestamp'] > $current_timestamp){
	// 	$output .= "";
	//  }
 }
 return $output;
}

