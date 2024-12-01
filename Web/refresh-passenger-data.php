<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

$query = "SELECT * FROM `passenger_location` where veichle_id={$_SESSION['veichle_id']}";
$data = $db_handle->runQuery($query);
$row_count = $db_handle->numRows($query);


$output = '';
for ($i = 0; $i < $row_count; $i++) {


    $time1_str = date("Y-m-d H:i:s");
    $time2_str = $data[$i]["inserted_at"];


    $time1 = new DateTime($time1_str);
    $time2 = new DateTime($time2_str);


    $time_difference_minutes = $time2->diff($time1)->days * 24 * 60 +
        $time2->diff($time1)->h * 60 +
        $time2->diff($time1)->i;



    if($time_difference_minutes<=30){
        $output .= '<tr>';
        $output .= '<td>' . ($i + 1) . '</td>';
        $output .= '<td>' . $data[$i]["lat"] . '</td>';
        $output .= '<td>' . $data[$i]["lon"] . '</td>';
        $output .= '<td>' . $data[$i]["inserted_at"] . '</td>';
        $output .= '<td>';
        $output .= '<div class="d-flex">';
        $output .= '<a href="View-Location?lat=' . $data[$i]["lat"] . '&lan=' . $data[$i]["lon"] . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>';
        $output .= '</div>';
        $output .= '</td>';
        $output .= '</tr>';
    }

}

echo $output;

