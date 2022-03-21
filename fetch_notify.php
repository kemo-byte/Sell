<?php

//fetch_user.php

	ob_start();
	session_start();
    $pageTitle = "fetch user"; 

    include "Cpanel/connect.php";
	include "includes/functions/functions.php";

    $notification = count_unseen_messages($_SESSION['user_id'],$conn);

    echo $notification;

ob_end_flush();
?>