<?php

//fetch_user.php

	ob_start();
	session_start();
    $pageTitle = "fetch user"; 

    include "Cpanel/connect.php";
	include "includes/functions/functions.php";
    $one1 = $_POST['i']; 
$query = "
SELECT * FROM users 
WHERE UserID =".$one1."
";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
 
  <th style="text-align:right">الحالة</th>
  <th style="text-align:right">المحادثة</th>
 </tr>
';

foreach($result as $row)
{
 $status = '';
 // fix timing problem by subtracting an hour from the timestamp
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 1 hour - 10 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($row['UserID'], $conn);
 if($user_last_activity > $current_timestamp)
 {
  $status = '<span style="font-size:1.2em" class="label label-success">متصل</span>';
 }
 else
 {
  $status = '<span style="font-size:1.2em" class="label label-danger">غير متصل</span>';
 }
 $output .='
 <tr>
  
  <td>'.$status.'</td>
  <td><button type="button" style="font-size:1.2em" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['UserID'].'" data-tousername="'.$row['Username'].'">بدأ المحادثة</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;

ob_end_flush();
?>