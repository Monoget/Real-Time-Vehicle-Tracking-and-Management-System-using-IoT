<?php
include('includes/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

if (isset($_GET['log'])) {
    $inserted_at=date("Y-m-d H:i:s");
    $log=$_GET['log'];

    $insert = $db_handle->insertQuery("INSERT INTO `log_data`( `log`, `inserted_at`) VALUES ('$log','$inserted_at')");
    if($insert)
        echo 'Insert get log'.$log;
    else
        echo 'Not Insert get log';
}
