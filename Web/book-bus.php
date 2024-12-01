<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Book Bus | GPS Tracker</title>
    <!-- Favicon icon -->
    <?php require_once('includes/css.php'); ?>

    <style>
        .bg-cell:hover {
            background-color: #99ef77;
            color: black;
        }

        .bg-cell.active-cell {
            background-color: #99ef77;
            color: black;
        }

        .bg-black.book-cell {
            background-color: #830000;
            color: white;
        }

        .bg-black.pending-cell {
            background-color: #001165;
            color: white;
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
                <?php
                if (isset($_GET['vehicle_id'])) {
                    ?>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Select Date</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="Insert" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Date <span
                                                        class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="date" name="date" id="date" class="form-control"
                                                       required onchange="updateData(this.value);">
                                            </div>
                                            <div class="col-sm-12 mt-3">
                                                <div class="table-responsive">
                                                    <table class="table table-responsive-md text-center">
                                                        <tbody id="tableBody">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="hidden" value="" name="time" id="selectedTimesInput" required>
                                                    <input type="hidden" value="" name="veichle_id" id="veichle_id" required>
                                                    <button type="submit" name="bookBus" class="btn btn-primary" id="submitButton" disabled>
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Vehicle List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Vehicle Name</th>
                                            <th>Driver Name</th>
                                            <th>Driver Number</th>
                                            <th>Book</th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        $data = $db_handle->runQuery("SELECT * FROM vehicle order by id desc");
                                        $row_count = $db_handle->numRows("SELECT * FROM vehicle order by id desc");

                                        for ($i = 0; $i < $row_count; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $data[$i]["name"]; ?></td>
                                                <td><?php echo $data[$i]["driver_name"]; ?></td>
                                                <td><?php echo $data[$i]["driver_number"]; ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="Book-Bus?vehicle_id=<?php echo $data[$i]["id"]; ?>"
                                                           class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                                    class="fa fa-pencil"></i> Book</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
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
    $(document).ready(function () {
        $('#example3').DataTable();
    });

    let maxSelections = 2;
    let selectedTimes = [];

    function bindClickEventToCells() {
        $('.bg-cell').click(function () {
            let isActive = $(this).hasClass('active-cell');
            let selectedCount = $('.active-cell').length;
            let cellTime = $(this).html();
            let rowIndex = $(this).closest('tr').attr('id');

            if (!isActive) {
                if (selectedCount >= maxSelections) {
                    return;
                }

                $(this).addClass('active-cell');
                selectedTimes.push(cellTime);
            } else {
                $(this).removeClass('active-cell');
                selectedTimes = selectedTimes.filter(time => time !== cellTime);
            }

            // Calculate time duration
            let timeDurations = calculateTimeDurations(selectedTimes);

            // Log the time durations to the console
            console.log('Time Durations:', timeDurations);

            $('#selectedTimesInput').val(selectedTimes.join(', '));
            $('#veichle_id').val(rowIndex);
            $('#timeDurationInput').val(timeDurations.join(', '));

            if (selectedTimes.length > 1) {
                $('#submitButton').prop('disabled', false);

                if (timeDurationExceedsLimit(timeDurations.length, 4)) {
                    alert('Time duration exceeds 4 hours.');
                    $(this).removeClass('active-cell');
                    selectedTimes.pop(cellTime);
                }
            } else {
                $('#submitButton').prop('disabled', true);
            }
        });
    }

    function calculateTimeDurations(times) {
        // Assuming times is an array of selected times in HH:MM format
        if (times.length < 2) {
            return ['N/A']; // Not enough times selected to calculate duration
        }

        let date = document.getElementById('date').value;

        // Convert times to Date objects for easier calculation
        let start = new Date(date + ' ' + times[0]); // Assuming today's date
        let end = new Date(date + ' ' + times[1]); // Assuming today's date

        let timeDurations = [];
        let current = new Date(start);

        while (current <= end) {
            let hours = current.getHours();
            let minutes = current.getMinutes();
            timeDurations.push(`${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`);
            current.setHours(hours + 1);
        }

        return timeDurations;
    }

    function timeDurationExceedsLimit(duration, limitHours) {
        return duration > limitHours;
    }

    $(document).ready(function () {
        bindClickEventToCells();
    });



    function updateData(val) {
        $.ajax({
            url: 'available-data.php',
            type: 'GET',
            data: {date: val <?php
                if(isset($_GET['vehicle_id']))
                    echo ', veichle_id:'.$_GET['vehicle_id'];
                ?>},
            dataType: 'html',
            success: function (data) {
                $('#tableBody').html(data);
                bindClickEventToCells();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ' + textStatus, errorThrown);
            }
        });
    }


</script>

</body>
</html>
