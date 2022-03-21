
<?php
  require_once "Cpanel/connect.php";
  
   $val = '';

  if(isset($_GET) && !empty($_GET)){
   $val = $_GET['s'];
   }

$stmt = $conn ->prepare("SELECT Name FROM items WHERE Name LIKE ?");

$stmt->execute(array('%'.$val.'%'));

$rows = $stmt->fetchAll();

foreach($rows as $row) {
   if(!empty($val)) {
      echo trim($row['Name']);
   }
}

?>