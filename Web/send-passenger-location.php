<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

$inserted_at=date("Y-m-d H:i:s");

$lat=$_GET['latitude'];
$lon=$_GET['longitude'];
$id=$_GET['id'];

$query = "INSERT INTO `passenger_location`(`veichle_id`,`lat`,`lon`, `inserted_at`) VALUES ('$id','$lat','$lon','$inserted_at')";
$insert = $db_handle->insertQuery($query);

if($insert){
    echo 'Success';
}else{
    echo 'Fail';
}

