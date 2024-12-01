<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

$date = $_GET['date'];
$veichle_id = $_GET['veichle_id'];
$passenger_id = $db_handle->checkValue($_SESSION['user_id']);

$timestamp = strtotime($date); // Replace with your desired date
$dayName = date('l', $timestamp);


$query = "SELECT * FROM vehicle where id='$veichle_id' order by id desc";
$data = $db_handle->runQuery($query);
$row_count = $db_handle->numRows($query);

$passenger_row = $db_handle->numRows("SELECT * FROM `book_time` WHERE passenger_id={$passenger_id} and date='$date'");

$output = "<table  class='table-primary'>";

if ($data[0]["veichle_type_id"] == 1 && $dayName != "Friday") {
    $output .= '<tr>Bus is not available in this date please select friday.</tr>';
} else {
    if ($passenger_row == 0) {
        for ($i = 0; $i < $row_count; $i++) {
            $timestamp = strtotime('01:00');
            $book_time_data = $db_handle->runQuery("SELECT * FROM book_time_difference order by id asc LIMIT  1");
            $row = 24 / $book_time_data[0]['time'];

            $output .= '<tr id="' . $data[$i]['id'] . '">';
            $output .= '<td><p style="width: 90px">' . $data[$i]["name"] . '</p></td>';
            for ($j = 1; $j <= floor((float)$row); $j++) {

                $time = date('h:i A', $timestamp);

                $start_time = date('h:i a', strtotime($book_time_data[0]['start_time']));

                $end_time = date('h:i a', strtotime($book_time_data[0]['end_time']));


                $l = 0;
                $status = 0;
                $passenger_num_of_row = $db_handle->numRows("SELECT * FROM `book_time` WHERE veichle_id={$veichle_id} and date='$date'");
                if ($passenger_num_of_row > 0) {
                    $passenger_data = $db_handle->runQuery("SELECT * FROM `book_time` WHERE veichle_id={$veichle_id} and date='$date'");
                    for ($k = 0; $k < $passenger_num_of_row; $k++) {
                        $dataArray = explode(',', $passenger_data[$k]["time"]);

                        for ($m = 0; $m < count($dataArray); $m++) {
                            if (strtotime($time) == strtotime($dataArray[$m])) {
                                $l = 1;
                                $status = $passenger_data[$k]["status"];
                            }
                        }
                    }

                }


                if (strtotime($time) >= strtotime($start_time) && strtotime($time) <= strtotime($end_time)) {
                    if ($l == 1 && $status == 0) {
                        $output .= '<td class="bg-black pending-cell">' . $time . '</td>';
                    } else if ($l == 1 && $status == 1) {
                        $output .= '<td class="bg-black book-cell">' . $time . '</td>';
                    } else {
                        $output .= '<td class="bg-cell">' . $time . '</td>';
                    }
                }


                $timestamp += +60 * 60 * $book_time_data[0]['time'];

            }

            $output .= '</tr>';
        }
    } else {
        $output .= '<tr>You Have already book data in this date.</tr>';
    }
}
$output .= "</table>";
echo $output;