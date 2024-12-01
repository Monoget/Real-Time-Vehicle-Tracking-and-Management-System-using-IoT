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
    <title>My Booking | GPS Tracker</title>
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
                            <h4 class="card-title">My Booking List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Passenger Name</th>
                                        <th>Vehicle Name</th>
                                        <th>Driver Name</th>
                                        <th>Driver Number</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                    <?php

                                    $query = "SELECT * FROM admin_login as a,book_time as b where b.passenger_id=a.id order by b.id desc";

                                    if ($_SESSION['role'] == 'Passenger') {
                                        $query = "SELECT * FROM admin_login as a,book_time as b where b.passenger_id=a.id and a.id={$_SESSION['user_id']} order by b.id desc";
                                    }

                                    $data = $db_handle->runQuery($query);
                                    $row_count = $db_handle->numRows($query);

                                    for ($i = 0; $i < $row_count; $i++) {

                                        $book_stats = $db_handle->runQuery("SELECT * FROM `book_stats` WHERE book_id={$data[$i]["id"]}");
                                        $num_of_row = $db_handle->numRows("SELECT * FROM `book_stats` WHERE book_id={$data[$i]["id"]}");
                                        $end = "0000-00-00 00:00:00";

                                        if ($num_of_row>0) {
                                            $end = $book_stats[0]["end_time"];
                                        }


                                        if ($end == "0000-00-00 00:00:00") {
                                            ?>
                                            <tr<?php

                                            $dataArray = explode(',', $data[$i]["time"]);
                                            $date = $data[$i]["date"];
                                            $time = $dataArray[count($dataArray) - 1];

                                            $last_time = $date . ' ' . $time;
                                            $current_time = date("Y-m-d h:i:s");


                                            $dataBook = $db_handle->runQuery("SELECT * FROM  book_time where id={$data[$i]['id']}");

                                            if ($dataBook[0]["status"] == 1)
                                                echo ' class="bg-approve"';
                                            else if ($dataBook[0]["status"] == 2)
                                                echo ' class="bg-decline"';
                                            else
                                                echo ' class="bg-pending"';
                                            ?>>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $data[$i]["name"]; ?></td>
                                                <td>
                                                    <?php
                                                    $veichle_data = $db_handle->runQuery("SELECT * FROM `vehicle` WHERE id={$dataBook[0]["veichle_id"]}");
                                                    echo $veichle_data[0]["name"];
                                                    ?>
                                                </td>
                                                <td><?php echo $veichle_data[0]["driver_name"]; ?></td>
                                                <td><?php echo $veichle_data[0]["driver_number"]; ?></td>
                                                <td><?php echo $data[$i]["date"]; ?></td>
                                                <td><?php echo $data[$i]["time"]; ?></td>
                                                <td>
                                                    <?php
                                                    $dataArray = explode(',', $data[$i]["time"]);

                                                    $book_difference = $db_handle->runQuery("SELECT * FROM `book_time_difference` WHERE id=1");

                                                    $hour = count($dataArray) * $book_difference[0]['time'];
                                                    echo $hour . ' Hour';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($_SESSION['role'] == 'Passenger') {
                                                        if (strtotime($current_time) <= strtotime($last_time)) {
                                                            ?>

                                                            <div class="d-flex">
                                                                <form action="Insert" method="post">
                                                                    <input type="hidden" name="book_id"
                                                                           value="<?php echo $data[$i]["id"]; ?>"
                                                                           required>
                                                                    <input type="hidden" name="veichle_id"
                                                                           value="<?php echo $dataBook[0]["veichle_id"]; ?>"
                                                                           required>
                                                                    <button type="submit" name="startButton"
                                                                            class="btn btn-success mr-1"
                                                                            id="startButton_<?php echo $i; ?>" disabled>
                                                                        Start
                                                                    </button>
                                                                </form>
                                                                <form action="Update" method="post">
                                                                    <input type="hidden" name="book_id"
                                                                           value="<?php echo $data[$i]["id"]; ?>"
                                                                           required>
                                                                    <input type="hidden" name="veichle_id"
                                                                           value="<?php echo $dataBook[0]["veichle_id"]; ?>"
                                                                           required>
                                                                    <button type="submit" name="endButton"
                                                                            class="btn btn-danger ml-1"
                                                                            id="endButton_<?php echo $i; ?>" disabled>
                                                                        End
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            echo "Time Up";
                                                        }

                                                    } else {
                                                        ?>
                                                        <div class="d-flex">
                                                            <a href="Update?bookStatus=1&book_id=<?php echo $data[$i]["id"]; ?>"
                                                               class="btn btn-success mr-1">Approve</a>
                                                            <a href="Update?bookStatus=2&book_id=<?php echo $data[$i]["id"]; ?>"
                                                               class="btn btn-danger ml-1">Decline</a>
                                                        </div>
                                                        <?php
                                                    } ?>
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
        echo "\tlet currentTime = new Date().getTime();\n";
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


            if($dataBook[0]["status"]==1){
                echo "\tlet enableStart_$i = false;\n";
                echo "\tconsole.log('Current Time:', new Date(currentTime));\n";
                echo "\tfor (let j = 0; j < dateTimes_$i.length; j++) {\n";
                echo "\t\t    console.log('PHP Time $i $j:', dateTimes_" . $i . "[j]);\n";
                echo "\t\t    if (currentTime >= dateTimes_" . $i . "[j].getTime()) {\n";
                echo "\t\t\t        enableStart_$i = true;\n";
                echo "\t\t\t        break;\n";
                echo "\t\t    }\n";
                echo "\t}\n";
            }

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
