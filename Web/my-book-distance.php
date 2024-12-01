<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Book Distance | GPS Tracker</title>
    <!-- Favicon icon -->
    <?php require_once('includes/css.php'); ?>

    <style>
        .bg-pending {
            background: #aed3ff !important;
        }

        .bg-approve {
            background: #c0ffb4 !important;
        }

        .bg-decline {
            background: #ffbbbb !important;
        }
    </style>
</head>
<body>

<!--*******************
    Preloader start
********************-->
<?php require_once('includes/preloader.php'); ?>
<!--*******************
    Preloader end
********************-->

<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <?php require_once('includes/navHeader.php'); ?>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <?php require_once('includes/header.php'); ?>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <?php require_once('includes/sidebar.php'); ?>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">My Booking Distance List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Passenger Name</th>
                                        <th>Vehicle Name</th>
                                        <th>Date</th>
                                        <th>Distance</th>
                                        <th>Actual Duration</th>
                                        <th>Complete Duration</th>
                                    </tr>
                                    <tbody>
                                    <?php

                                    function haversineDistance($lat1, $lon1, $lat2, $lon2) {
                                        $R = 6371; // Earth's radius in kilometers

                                        $lat1Rad = deg2rad($lat1);
                                        $lon1Rad = deg2rad($lon1);
                                        $lat2Rad = deg2rad($lat2);
                                        $lon2Rad = deg2rad($lon2);

                                        $deltaLat = $lat2Rad - $lat1Rad;
                                        $deltaLon = $lon2Rad - $lon1Rad;

                                        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
                                            cos($lat1Rad) * cos($lat2Rad) *
                                            sin($deltaLon / 2) * sin($deltaLon / 2);

                                        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                                        $distance = $R * $c;

                                        return $distance;
                                    }

                                    function calculateTotalDistance($coordinates) {
                                        $totalDistance = 0;

                                        for ($i = 0; $i < count($coordinates) - 1; $i++) {
                                            $lat1 = $coordinates[$i][0];
                                            $lon1 = $coordinates[$i][1];
                                            $lat2 = $coordinates[$i + 1][0];
                                            $lon2 = $coordinates[$i + 1][1];

                                            $distance = haversineDistance($lat1, $lon1, $lat2, $lon2);
                                            $totalDistance += $distance;
                                        }

                                        return $totalDistance;
                                    }

                                    $query = "SELECT * FROM admin_login as a,book_time as b where b.passenger_id=a.id order by b.id desc";

                                    if ($_SESSION['role'] == 'Passenger') {
                                        $query = "SELECT * FROM admin_login as a,book_time as b where b.passenger_id=a.id and a.id={$_SESSION['user_id']} order by b.id desc";
                                    }

                                    $data = $db_handle->runQuery($query);
                                    $row_count = $db_handle->numRows($query);

                                    $coordinatesHistory = [];

                                    for ($i = 0; $i < $row_count; $i++) {

                                        $book_stats = $db_handle->runQuery("SELECT * FROM `book_stats` WHERE book_id={$data[$i]["id"]}");
                                        $num_of_row = $db_handle->numRows("SELECT * FROM `book_stats` WHERE book_id={$data[$i]["id"]}");
                                        $end = "0000-00-00 00:00:00";

                                        if ($num_of_row>0) {
                                            $end = $book_stats[0]["end_time"];
                                        }

                                        if ($end != "0000-00-00 00:00:00") {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $data[$i]["name"]; ?></td>
                                                <td>
                                                    <?php
                                                    $veichle_data = $db_handle->runQuery("SELECT * FROM `vehicle` WHERE id={$data[0]["veichle_id"]}");
                                                    echo $veichle_data[0]["name"];
                                                    ?>
                                                </td>
                                                <td><?php echo $data[$i]["date"]; ?></td>
                                                <td>
                                                    <?php

                                                    $dataBook = $db_handle->runQuery("SELECT * FROM  book_time_stat where book_id={$data[$i]['id']};");
                                                    $row_num = $db_handle->numRows("SELECT * FROM  book_time_stat where book_id={$data[$i]['id']};");

                                                    for($j=0;$j<$row_num;$j++){
                                                        $coordinatesHistory[] = [$dataBook[$j]['latitude'], $dataBook[$j]['longditide']];
                                                    }

                                                    $totalDistance = calculateTotalDistance($coordinatesHistory);

                                                    echo $totalDistance. " km";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $dataArray = explode(',', $data[$i]["time"]);

                                                    $book_difference = $db_handle->runQuery("SELECT * FROM `book_time_difference` WHERE id=1");

                                                    $hour = count($dataArray) * $book_difference[0]['time'];
                                                    echo $hour . ' Hour';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    $date = $data[$i]["date"];
                                                    $time = $dataArray[count($dataArray) - 1];

                                                    $last_time = $date . ' ' . $time;

                                                    $startTime = new DateTime($last_time);
                                                    $endTime = new DateTime($end);

                                                    $interval = $startTime->diff($endTime);

                                                    echo $interval->format('%h Hrs %i Mins');
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    <!--**********************************
        Footer start
    ***********************************-->
    <?php require_once('includes/footer.php'); ?>
    <!--**********************************
        Footer end
    ***********************************-->

    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<?php require_once('includes/js.php'); ?>

<script>
    function checkAndEnableButtons() {
        <?php
        $book_difference = $db_handle->runQuery("SELECT * FROM `book_time_difference` WHERE id=1");
        for ($i = 0; $i < $row_count; $i++) {
            $dateValue = $data[$i]["date"];
            $dataArray = explode(',', $data[$i]["time"]);

            $book_stats = $db_handle->runQuery("SELECT * FROM `book_stats` WHERE book_id={$data[$i]["id"]}");
            $start = 0;

            if (isset($book_stats)) {
                $start = 1;
            }


            echo "let dateTimes_$i = [];\n";

            for ($j = 0; $j < count($dataArray); $j++) {
                $timeValue = trim($dataArray[$j]);
                $dateTimeValue = $dateValue . ' ' . $timeValue;

                if (($timestamp = strtotime($dateTimeValue)) !== false) {
                    echo "\tdateTimes_$i.push(new Date(" . ($timestamp * 1000) . "));\n";
                }
            }

            echo "\tlet currentTime = new Date().getTime();\n";
            echo "\tlet enableStart_$i = false;\n";
            echo "\tconsole.log('Current Time:', new Date(currentTime));\n";
            echo "\tfor (let j = 0; j < dateTimes_$i.length; j++) {\n";
            echo "\t\t    console.log('PHP Time $i $j:', dateTimes_" . $i . "[j]);\n";
            echo "\t\t    if (currentTime >= dateTimes_" . $i . "[j].getTime()) {\n";
            echo "\t\t\t        enableStart_$i = true;\n";
            echo "\t\t\t        break;\n";
            echo "\t\t    }\n";
            echo "\t}\n";


            if ($start == 0) {
                echo "\tif (enableStart_$i) {\n";
                echo "\t    $('#startButton_$i').prop('disabled', false);\n";
                echo "\t} else {\n";
                echo "\t\t    $('#startButton_$i').prop('disabled', true);\n";
                echo "\t\t    $('#endButton_$i').prop('disabled', true);\n";
                echo "\t}\n";
            } else {
                echo "\tif (enableStart_$i) {\n";
                echo "\t    $('#startButton_$i').prop('disabled', true);\n";
                echo "\t    $('#endButton_$i').prop('disabled', false);\n";
                echo "\t} else {\n";
                echo "\t\t    $('#startButton_$i').prop('disabled', true);\n";
                echo "\t\t    $('#endButton_$i').prop('disabled', true);\n";
                echo "\t}\n";
            }

        }
        ?>
    }

    setInterval(checkAndEnableButtons, 1000);

    $(document).ready(function () {
        $('#example3').DataTable();
    });

    function updateTable() {
        $.ajax({
            url: 'refresh-table-data.php',
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $('#tableBody').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ' + textStatus, errorThrown);
            }
        });
    }

    updateTable();

    setInterval(function () {
        updateTable();
    }, 5000);
</script>

</body>
</html>
