<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

$query = "SELECT * FROM record order by rid desc limit 10";
$data = $db_handle->runQuery($query);
$row_count = $db_handle->numRows($query);


$output = '';
for ($i = 0; $i < $row_count; $i++) {
    $output .= '<tr>';
    $output .= '<td>' . ($i + 1) . '</td>';
    $output .= '<td>Lat: &nbsp;' . $data[$i]["lat"] . ' <br/>Lon: ' . $data[$i]["lat"] . '</td>';
    $output .= '<td>' . $data[$i]["inserted_at"] . '</td>';
    $output .= '</tr>';
}

echo $output;

