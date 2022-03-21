<?php 



	
    session_start();

	include 'Cpanel/connect.php';
	include 'includes/functions/functions.php';

	$brokerage = 0.20;


// price,buyer,seller,item
$price = $_POST['price'];
$buyer = $_POST['buyer'];
$seller = $_POST['seller'];
$item = $_POST['item'] ;

$price_after_brokerage = $price - ($price * $brokerage);
$price_after_halve_of_brokerage = $price - ($price * ($brokerage/2));

// take the money form the buyer

$stmt = $conn->prepare("update users set balance = balance + ".$price_after_brokerage." where UserID = ".$seller);

$stmt->execute();

$count = $stmt->rowCount();

if($count > 0){

    // change status of transaction

//$stmt1 = $conn->prepare("update transactions set status = 0 where buyer=".$buyer." and item =".$item);
$stmt1 = $conn->prepare("delete from transactions where buyer=".$buyer." and item =".$item);

$stmt1->execute();

$count1 = $stmt1->rowCount();
$client = getOneFrom('Username','users','where UserID='.$buyer);
$service = getOneFrom('Name','items','where item_ID='.$item);
if($count1 > 0){
     // add notifiction 
     $message = "تم تسلم خدمة  " . $service['Name'] . " من قبل العميل ". $client['Username'] ;
     $stmt1 = $conn->prepare("insert into
                         notification(buyer,seller,message,status)
                         values(?,?,?,?)
                         ");
     $stmt1->execute( [$buyer,$seller,$message,1] );


    echo 1;
} else {
    echo 0;
}


} else {
    echo 0;
}



