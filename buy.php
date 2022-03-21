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


// check the buyer balance
$stmt2 = $conn->prepare("select balance from users where UserID=".$buyer);

$stmt2->execute();

$row = $stmt2->fetch();


if($row['balance'] >= $price){


// take the money form the buyer

$stmt = $conn->prepare("update users set balance = balance - ".$price." where UserID = ".$buyer);

$stmt->execute();

$count = $stmt->rowCount();

if($count > 0){
   


// add transaction

$stmt1 = $conn->prepare("insert into
                         transactions(buyer,seller,price,item,status)
                          values(?,?,?,?,?)
                          ");
$stmt1->execute( [$buyer,$seller,$price,$item,1] );

$count1 = $stmt1->rowCount();

$client = getOneFrom('Username','users','where UserID='.$buyer);
$service = getOneFrom('Name','items','where item_ID='.$item);
if($count1 > 0){
    // add notifiction 
        $message = "تم طلب خدمة  " . $service['Name'] . " من قبل العميل ". $client['Username'] . "بسعر " . $price ." جنيه";
        $stmt1 = $conn->prepare("insert into
                            notification(buyer,seller,message,status)
                            values(?,?,?,?)
                            ");
        $stmt1->execute( [$buyer,$seller,$message,1] );

    echo 2;
} else {
    echo 1;
}


} else {
    echo 3;
}


} else if($row['balance'] < $price){
    echo 0;
}

