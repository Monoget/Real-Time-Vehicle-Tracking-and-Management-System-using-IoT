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
    <title>User List | GPS Tracker</title>
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
                if (isset($_GET["user_id"])) {
                    $data = $db_handle->runQuery("SELECT * FROM admin_login where id={$_GET["user_id"]}");
                    ?>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit User</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">

                                    <form action="Update" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $data[0]["id"]; ?>" required>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" class="form-control" value="<?php echo $data[0]["name"]; ?>" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">User Email <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="email" name="email" class="form-control" value="<?php echo $data[0]["email"]; ?>" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">User Password <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" name="password" class="form-control" value="<?php echo $data[0]["password"]; ?>" placeholder="Password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">User Icon</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="user_icon">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <img src="<?php echo $data[0]["image"]; ?>" class="img-fluid" alt="" style="height: 50px;width: 50px;border-radius: 50%"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="sel1" name="role" required>
                                                    <option>Choose...</option>
                                                    <option value="Driver" <?php
                                                                                if($data[0]["role"]=='Driver')
                                                                                    echo 'selected';
                                                                            ?>>
                                                                            Driver</option>
                                                    <option value="Passenger" <?php
                                                                                if($data[0]["role"]=='Passenger')
                                                                                    echo 'selected';
                                                                            ?>>
                                                        Passenger</option>
                                                    <option value="Admin" <?php
                                                                            if($data[0]["role"]=='Admin')
                                                                                echo 'selected';
                                                                            ?>>
                                                                            Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Vehicle ID </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="vehicle_id" class="form-control" value="<?php echo $data[0]["veichle_id"]; ?>" placeholder="Ex: 1,2,3 (By Default it is 0)" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Book Limit </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="book_limit" class="form-control" value="<?php echo $data[0]["book_limit"]; ?>" placeholder="Ex: 1,2,3 (By Default it is 4)">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary" name="editUser">Submit</button>
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
                            <h4 class="card-title">User List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Inserted At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $data = $db_handle->runQuery("SELECT * FROM admin_login order by id desc");
                                    $row_count = $db_handle->numRows("SELECT * FROM admin_login order by id desc");

                                    for ($i = 0; $i < $row_count; $i++) {
                                    ?>
                                    <tr>
                                        <td><img class="rounded-circle" width="35" src="<?php echo $data[$i]["image"]; ?>" alt=""></td>
                                        <td><?php echo $data[$i]["name"]; ?></td>
                                        <td><a href="javascript:void(0);"><strong><?php echo $data[$i]["email"]; ?></strong></a></td>
                                        <td><?php echo $data[$i]["role"]; ?></td>
                                        <td><?php echo $data[$i]["inserted_at"]; ?></td>
                                        <td><?php echo $data[$i]["updated_at"]; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="User-List?user_id=<?php echo $data[$i]["id"]; ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="User-List?del_user_id=<?php echo $data[$i]["id"]; ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
if (isset($_GET['del_user_id'])) {
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
                    let user_id = params.get('del_user_id');
                    $.ajax({
                        type: 'get',
                        url: 'Delete',
                        data: {
                            user_id: user_id
                        },
                        success: function (data) {
                            swal({
                                title: 'User Delete',
                                text: 'User Deleted Successfully',
                                type: 'error',
                                confirmButtonClass: 'btn-danger',
                                confirmButtonText: 'OK',
                            }).then((e) => {
                                window.location = 'User-List';
                            });
                        }
                    });
                } else {
                    swal({
                        title: 'Cancelled',
                        text: 'Your user is safe :)',
                        type: 'error',
                        confirmButtonClass: 'btn-success',
                        confirmButtonText: 'OK',
                    }).then((e) => {
                        window.location = 'User-List';
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