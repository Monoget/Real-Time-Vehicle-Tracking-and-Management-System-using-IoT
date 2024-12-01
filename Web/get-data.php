<?php
include('includes/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

$date = date('Y-m-d');

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = $db_handle->checkValue($_GET['vehicle_id']);
    $latitude = $db_handle->checkValue($_GET['latitude']);
    $langditude = $db_handle->checkValue($_GET['langditude']);

    $inserted_at = date("Y-m-d H:i:s");

    $query = "SELECT * FROM `route` where vehicle_id='$vehicle_id'";

    $vehicle = $db_handle->runQuery($query);
    $row = $db_handle->numRows($query);


    $book_stats = "SELECT * FROM book_stats where veichle_id='$vehicle_id' and end_time='0000-00-00 00:00:00'";
    $vehicle_stats = $db_handle->runQuery($book_stats);
    $vehicle_stats_row = $db_handle->numRows($book_stats);

    $page_id = 0;
    if ($row > 0) {
        $route_id = $vehicle[0]['id'];
        $update = $db_handle->insertQuery("UPDATE `route` SET `latitude`='$latitude',`langditude`='$langditude',`inserted_at`='$inserted_at' WHERE `id`='$route_id'");
        echo 'Update';

        if ($vehicle_stats_row > 0) {

            $current_time = date('Y-m-d h:i:s');

            $start_time = $vehicle_stats[0]['start_time'];

            $passenger_id = $vehicle_stats[0]['passenger_id'];
            $book_id = $vehicle_stats[0]['book_id'];

            if(strtotime($current_time)<=strtotime($start_time)){
                if ($latitude > 0 && $langditude > 0) {
                    $insert = $db_handle->insertQuery("INSERT INTO `book_time_stat`( `book_id`, `passenger_id`, `veichle_id`, `latitude`, `longditide`, `inserted_at`) VALUES ('$book_id','$passenger_id','$vehicle_id','$latitude','$langditude','$inserted_at')");
                }
            }
        }
    } else {
        $insert = $db_handle->insertQuery("INSERT INTO `route` (`vehicle_id`, `latitude`, `langditude`, `inserted_at`) VALUES ('$vehicle_id','$latitude','$langditude','$inserted_at')");
        echo 'Insert get data';
    }
}
