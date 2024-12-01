<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

if (isset($_POST["editVehicle"])) {
    $id = $db_handle->checkValue($_POST['id']);

    $name = $db_handle->checkValue($_POST['name']);
    $driver_name = $db_handle->checkValue($_POST['driver_name']);
    $driver_number = $db_handle->checkValue($_POST['driver_number']);

    $update = $db_handle->insertQuery("UPDATE `vehicle` SET `name`='$name',`driver_name`='$driver_name',`driver_number`='$driver_number' WHERE id='$id'");

    echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='Vehicle-List';
                </script>";
}

if (isset($_POST["editUser"])) {
    $id = $db_handle->checkValue($_POST['id']);

    $name = $db_handle->checkValue($_POST['name']);
    $email = $db_handle->checkValue($_POST['email']);
    $password = $db_handle->checkValue($_POST['password']);

    $role = $db_handle->checkValue($_POST['role']);
    $book_limit = $db_handle->checkValue($_POST['book_limit']);

    $attach_files = '';
    $query_add = '';
    if (!empty($_FILES['user_icon']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);

        $file_name = $RandomAccountNumber . "_" . $_FILES['user_icon']['name'];
        $file_size = $_FILES['user_icon']['size'];
        $file_tmp = $_FILES['user_icon']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (
            $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
            && $file_type != "gif"
        ) {
            $attach_files = '';
        } else {

            $data = $db_handle->runQuery("SELECT * FROM admin_login where id={$id}");
            unlink($data[0]["image"]);

            move_uploaded_file($file_tmp, "images/profile/" . $file_name);
            $attach_files = 'images/profile/' . $file_name;
            $query_add .= ",`image`='" . $attach_files . "'";
            echo $query_add;
        }

    } else {
        $query_add .= '';
    }

    $row = $db_handle->numRows("SELECT * FROM admin_login where email={$email}");
    if ($row == 0) {
        $update = $db_handle->insertQuery("UPDATE `admin_login` SET `name`='$name'" . $query_add . ",`email`='$email',`password`='$password',`role`='$role',`book_limit`='$book_limit' WHERE id='$id'");

        echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='User-List';
                </script>";
    } else {
        echo "<script>
                document.cookie = 'alert = 7;';
                window.location.href='User-List';
                </script>";
    }
}

if (isset($_POST["editProfile"])) {
    $id = $db_handle->checkValue($_SESSION['user_id']);

    $name = $db_handle->checkValue($_POST['name']);


    $attach_files = '';
    $query_add = '';
    if (!empty($_FILES['user_icon']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);

        $file_name = $RandomAccountNumber . "_" . $_FILES['user_icon']['name'];
        $file_size = $_FILES['user_icon']['size'];
        $file_tmp = $_FILES['user_icon']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (
            $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
            && $file_type != "gif"
        ) {
            $attach_files = '';
        } else {

            $data = $db_handle->runQuery("SELECT * FROM admin_login where id={$id}");
            unlink($data[0]["image"]);

            move_uploaded_file($file_tmp, "images/profile/" . $file_name);
            $attach_files = 'images/profile/' . $file_name;
            $query_add .= ",`image`='" . $attach_files . "'";
            echo $query_add;
        }

    } else {
        $query_add .= '';
    }

    $update = $db_handle->insertQuery("UPDATE `admin_login` SET `name`='$name'" . $query_add . " WHERE id='$id'");

    echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='Profile';
                </script>";
}

if (isset($_POST["editPass"])) {
    $id = $db_handle->checkValue($_SESSION['user_id']);

    $old_pass = $db_handle->checkValue($_POST['old_pass']);

    $new_pass = $db_handle->checkValue($_POST['new_pass']);

    $cnfrm_pass = $db_handle->checkValue($_POST['cnfrm_pass']);


    $row = $db_handle->numRows("SELECT * FROM admin_login where id={$id} and password={$old_pass}");

    if($row==1&&$new_pass==$cnfrm_pass){
        $update = $db_handle->insertQuery("UPDATE `admin_login` SET `password`='$new_pass' WHERE id='$id'");

        echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='Profile';
                </script>";
    }else{
        echo "<script>
                document.cookie = 'alert = 6;';
                window.location.href='Profile';
                </script>";
    }
}

if (isset($_GET["bookStatus"])) {
    $id = $db_handle->checkValue($_GET['book_id']);
    $status = $db_handle->checkValue($_GET['bookStatus']);

    $updated_at = date("Y-m-d H:i:s");

    $update = $db_handle->insertQuery("UPDATE `book_time` SET `status`='$status',`updated_at`='$updated_at' WHERE `id`='$id'");

    echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='My-Booking';
                </script>";
}

if (isset($_POST["endButton"])) {
    $book_id = $db_handle->checkValue($_POST['book_id']);
    $veichle_id = $db_handle->checkValue($_POST['veichle_id']);
    $passenger_id = $db_handle->checkValue($_SESSION['user_id']);

    $updated_at = date("Y-m-d H:i:s");

    $update = $db_handle->insertQuery("UPDATE `book_stats` SET `end_time`='$updated_at' WHERE `book_id`='$book_id'");

    echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='My-Booking';
                </script>";
}