<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

if (isset($_POST["addVehicle"])) {

    $name = $db_handle->checkValue($_POST['name']);
    $driver_name = $db_handle->checkValue($_POST['driver_name']);
    $driver_number = $db_handle->checkValue($_POST['driver_number']);
    $inserted_at = date("Y-m-d H:i:s");
    $insert = $db_handle->insertQuery("INSERT INTO `vehicle`(`name`, `driver_name`, `driver_number`, `inserted_at`) VALUES ('$name','$driver_name','$driver_number','$inserted_at')");

    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Add-Vehicle';
                </script>";
}


if (isset($_POST["addUser"])) {

    $name = $db_handle->checkValue($_POST['name']);
    $email = $db_handle->checkValue($_POST['email']);
    $password = $db_handle->checkValue($_POST['password']);

    $role = $db_handle->checkValue($_POST['role']);
    $inserted_at = date("Y-m-d H:i:s");

    $attach_files = '';
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
            move_uploaded_file($file_tmp, "images/profile/" . $file_name);
            $attach_files = "images/profile/" . $file_name;
        }

    } else {
        $attach_files = 'images/profile/12.png';
    }

    $row = $db_handle->numRows("SELECT * FROM admin_login where email={$email}");
    if ($row == 0) {
        $insert = $db_handle->insertQuery("INSERT INTO `admin_login`( `name`, `image`, `email`, `password`, `role`, `inserted_at`) VALUES ('$name','$attach_files','$email','$password','$role','$inserted_at')");

        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Add-User';
                </script>";
    } else {
        echo "<script>
                document.cookie = 'alert = 7;';
                window.location.href='Add-User';
                </script>";
    }
}

if (isset($_POST["bookBus"])) {
    $date = $db_handle->checkValue($_POST['date']);
    $time = $db_handle->checkValue($_POST['time']);

    $timeArray = explode(',', $time);

    $startTime = $timeArray[0];
    $endTime = $timeArray[1];

    $startDateTime = new DateTime($startTime);
    $endDateTime = new DateTime($endTime);

    $interval = new DateInterval('PT1H');
    $currentDateTime = clone $startDateTime;

    $hoursArray = array();

    while ($currentDateTime <= $endDateTime) {
        $hoursArray[] = $currentDateTime->format('h:i A');
        $currentDateTime->add($interval);
    }

    $hoursString = implode(', ', $hoursArray);

    $veichle_id = $db_handle->checkValue($_POST['veichle_id']);
    $passenger_id = $db_handle->checkValue($_SESSION['user_id']);

    $inserted_at = date("Y-m-d H:i:s");

    $insert = $db_handle->insertQuery("INSERT INTO `book_time`(`passenger_id`, `veichle_id`, `date`, `time`, `status`, `inserted_at`) VALUES ('$passenger_id','$veichle_id','$date','$hoursString','0','$inserted_at')");

    if ($insert) {
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='My-Booking';
                </script>";
    } else {
        echo "<script>
                document.cookie = 'alert = 7;';
                window.location.href='Book-Bus';
                </script>";
    }
}

if (isset($_POST["startButton"])) {
    $book_id = $db_handle->checkValue($_POST['book_id']);
    $veichle_id = $db_handle->checkValue($_POST['veichle_id']);
    $passenger_id = $db_handle->checkValue($_SESSION['user_id']);

    $inserted_at = date("Y-m-d H:i:s");

    $insert = $db_handle->insertQuery("INSERT INTO `book_stats`(`book_id`, `passenger_id`, `veichle_id`, `start_time`, `inserted_at`) VALUES ('$book_id','$passenger_id','$veichle_id','$inserted_at','$inserted_at')");

    if ($insert) {
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='My-Booking';
                </script>";
    } else {
        echo "<script>
                document.cookie = 'alert = 7;';
                window.location.href='My-Booking';
                </script>";
    }
}