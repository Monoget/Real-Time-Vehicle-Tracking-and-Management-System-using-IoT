<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

$query = "SELECT * FROM vehicle as v,record as r where v.id=r.vid order by v.id desc limit 1";
$data = $db_handle->runQuery($query);
$row_count = $db_handle->numRows($query);


$output = '';
for ($i = 0; $i < $row_count; $i++) {
    $output .= '<tr>';
    $output .= '<td>' . ($i + 1) . '</td>';
    $output .= '<td>' . $data[$i]["id"] . '</td>';
    $output .= '<td>' . $data[$i]["name"] . '</td>';
    $output .= '<td>' . $data[$i]["driver_name"] . '</td>';
    $output .= '<td>' . $data[$i]["driver_number"] . '</td>';
    $output .= '<td>' . $data[$i]["lat"] . '</td>';
    $output .= '<td>' . $data[$i]["lon"] . '</td>';
    $output .= '<td>' . $data[$i]["inserted_at"] . '</td>';
    $output .= '<td>';
    $output .= '<div class="d-flex">';
    $output .= '<a href="Bus-Location?lat=' . $data[$i]["lat"] . '&lan=' . $data[$i]["lon"] . '&id=' . $data[$i]["id"] . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>';
    $output .= '</div>';
    $output .= '</td>';
    $output .= '</tr>';
}

echo $output;

