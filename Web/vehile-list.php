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
    <title>Vehicle List | GPS Tracker</title>
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
                <?php
                if (isset($_GET["vehicle_id"])) {
                    $data = $db_handle->runQuery("SELECT * FROM vehicle where id={$_GET["vehicle_id"]}");
                    ?>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Vehicle</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="Update" method="post">
                                        <input type="hidden" name="id" value="<?php echo $data[0]["id"]; ?>" required>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Vehicle Name <span
                                                        class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="Ex: Rupsha" value="<?php echo $data[0]["name"]; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Driver Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="driver_name" class="form-control"
                                                       placeholder="Ex: XXXX" value="<?php echo $data[0]["driver_name"]; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Driver Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="driver_number" class="form-control"
                                                       placeholder="Ex: 01XXX-XXXXXX" value="<?php echo $data[0]["driver_number"]; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary" name="editVehicle">Submit
                                                </button>
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
                                            <th>VID</th>
                                            <th>Vehicle Name</th>
                                            <th>Driver Name</th>
                                            <th>Driver Number</th>
                                            <th>Inserted At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $data = $db_handle->runQuery("SELECT * FROM vehicle order by id desc");
                                        $row_count = $db_handle->numRows("SELECT * FROM vehicle order by id desc");

                                        for ($i = 0; $i < $row_count; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $data[$i]["id"]; ?></td>
                                                <td><?php echo $data[$i]["name"]; ?></td>
                                                <td><?php echo $data[$i]["driver_name"]; ?></td>
                                                <td><?php echo $data[$i]["driver_number"]; ?></td>
                                                <td><?php echo $data[$i]["inserted_at"]; ?></td>
                                                <td><?php echo $data[$i]["updated_at"]; ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="Vehicle-List?vehicle_id=<?php echo $data[$i]["id"]; ?>"
                                                           class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                                    class="fa fa-pencil"></i></a>
                                                        <a href="Vehicle-List?del_vehicle_id=<?php echo $data[$i]["id"]; ?>"
                                                           class="btn btn-danger shadow btn-xs sharp"><i
                                                                    class="fa fa-trash"></i></a>
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

<?php
if (isset($_GET['del_vehicle_id'])) {
    ?>
    <script type="text/javascript">
        setTimeout(function () {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Vehicle!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then((willDelete) => {
                    if (willDelete.dismiss!='cancel') {
                        let currentUrl = window.location.href;
                        let params = (new URL(currentUrl)).searchParams;
                        let vehicle_id = params.get('del_vehicle_id');
                        $.ajax({
                            type: 'get',
                            url: 'Delete',
                            data: {
                                vehicle_id: vehicle_id
                            },
                            success: function (data) {
                                swal({
                                    title: 'Vehicle Delete',
                                    text: 'Vehicle Deleted Successfully',
                                    type: 'error',
                                    confirmButtonClass: 'btn-danger',
                                    confirmButtonText: 'OK',
                                }).then((e) => {
                                    window.location = 'Vehicle-List';
                                });
                            }
                        });
                    } else {
                        swal({
                            title: 'Cancelled',
                            text: 'Your vehicle is safe :)',
                            type: 'error',
                            confirmButtonClass: 'btn-success',
                            confirmButtonText: 'OK',
                        }).then((e) => {
                            window.location = 'Vehicle-List';
                        });
                    }
                });
        }, 1000);
    </script>
    <?php
}
?>


</body>
</html>