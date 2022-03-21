<?php

//fetch_user.php

	ob_start();
	session_start();
    $pageTitle = "fetch user"; 

    include "Cpanel/connect.php";
	include "includes/functions/functions.php";
// and GroupID != 1 ===> remove admins from chat
$query = "
SELECT * FROM users 
WHERE UserID != '".$_SESSION['user_id']."' and GroupID = 1
";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <th style="text-align:right">الإسم</th>
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
  $status = '<span class="label label-success">متصل</span>';
 }
 else
 {
  $status = '<span class="label label-danger">غير متصل</span>';
 }
 $output .='
 <tr>
  <td><a href="p.php?userid='.$row['UserID'].'"><span>'.$row['Username'].' </span><span>'.count_unseen_message($row['UserID'], $_SESSION['user_id'], $conn).'</span></a></td>
  <td>'.$status.'</td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['UserID'].'" data-tousername="'.$row['Username'].'">بدأ المحادثة</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;

ob_end_flush();
?>