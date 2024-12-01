<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

$query = "SELECT lat, lon FROM record where vid={$_GET['id']}";
$result = $db_handle->runQuery($query);
$data = array();
if (!empty($result)) {
    $data['lat'] = $result[0]['lat'];
    $data['lng'] = $result[0]['lon'];
}

header('Content-Type: application/json');
echo json_encode($data);

