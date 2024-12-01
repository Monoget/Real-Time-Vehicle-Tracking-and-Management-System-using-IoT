<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

if (isset($_GET['vehicle_id'])) {
    $db_handle->runQuery("delete FROM vehicle where id={$_GET['vehicle_id']}");
    echo 'success';
}

if (isset($_GET['user_id'])) {
    $data = $db_handle->runQuery("SELECT * FROM admin_login where id={$_GET['user_id']}");
    unlink($data[0]["image"]);

    $db_handle->runQuery("delete FROM admin_login where id={$_GET['user_id']}");
    echo 'success';
}