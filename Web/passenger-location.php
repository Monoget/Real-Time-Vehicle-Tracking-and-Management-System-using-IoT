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
    <title>Passenger Location | GPS Tracker</title>
    <!-- Favicon icon -->
    <?php require_once('includes/css.php'); ?>
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
                            <h4 class="card-title">Passenger List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Inserted At</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                    <!-- PHP-generated table rows will be placed here -->
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
    $(document).ready(function() {
        $('#example3').DataTable();
    });

    function updateTable() {
        $.ajax({
            url: 'refresh-passenger-data.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#tableBody').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ' + textStatus, errorThrown);
            }
        });
    }

    updateTable();

    setInterval(function() {
        updateTable();
    }, 5000);
</script>

</body>
</html>
