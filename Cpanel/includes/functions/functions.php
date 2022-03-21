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
	** Title Function v1.0
	** Title function that echo the page title
	** 
	*/

	function getTitle(){

		global $pageTitle ;

		if(isset($pageTitle)){

			echo $pageTitle;
		}else{

			echo "default";
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
		echo "<div class='alert alert-info'> سوف يتم تحويل الصفحة $link بعد " . $seconds . " ثواني";

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