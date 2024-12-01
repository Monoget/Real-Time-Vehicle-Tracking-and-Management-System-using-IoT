<?php
include('includes/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

if (isset($_GET['vid'])) {
    $vid = $db_handle->checkValue($_GET['vid']);
    $lat = $db_handle->checkValue($_GET['lat']);
    $lon = $db_handle->checkValue($_GET['lon']);

    $inserted_at = date("Y-m-d H:i:s");

    $insert = $db_handle->insertQuery("INSERT INTO `record` (`vid`, `lat`, `lon`, `inserted_at`) VALUES ('$vid','$lat','$lon','$inserted_at')");
    
    if ($insert) {
        echo "Data inserted successfully";
    } else {
        echo "Error inserting data";
    }
} else {
    echo "Missing parameters";
}
?>
