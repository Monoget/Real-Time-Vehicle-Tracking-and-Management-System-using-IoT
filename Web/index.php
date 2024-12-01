<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();
if (isset($_POST["submit"])) {
    $email = $db_handle->checkValue($_POST['email']);
    $password = $db_handle->checkValue($_POST['password']);

    $login = $db_handle->numRows("SELECT * FROM admin_login WHERE email='$email' and password='$password'");

    $login_data = $db_handle->runQuery("SELECT * FROM admin_login WHERE email='$email' and password='$password'");

    if($login==1){
        $_SESSION['user_id']=$login_data[0]["id"];
        $_SESSION['role']=$login_data[0]["role"];

        if($login_data[0]["veichle_id"]!=0){
            $_SESSION['veichle_id']=$login_data[0]["veichle_id"];
        }

        echo "<script>
                document.cookie = 'alert = 1;';
                window.location.href='Dashboard';
                </script>";
    }else{
        echo "<script>
                document.cookie = 'alert = 6;';
                window.location.href='Login';
                </script>";
    }
}

/*$check_ip = $db_handle->numRows("SELECT * FROM admin_login WHERE ip='{$_SERVER['REMOTE_ADDR']}'");

if($check_ip>=1){
    echo "<script>
                window.location.href='../admin';
                </script>";
}else{
    echo "<script>
                window.location.href='../Home';
                </script>";
}*/

if(isset($_SESSION["name"])){
    echo "<script>
                window.location.href='Dashboard';
                </script>";
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | GPS Tracker</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="vendor/toastr/css/toastr.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .toast-success {
            background-color: #36C95F;
        }


        .toast-error {
            background-color: #b50000;
        }
    </style>

    <script>
        if (location.protocol !== 'https:') {
            location.replace(`https:${location.href.substring(location.protocol.length)}`);
        }
    </script>

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="vendor/toastr/js/toastr.min.js" type="text/javascript"></script>
    <script src="js/plugins-init/toastr-init.js" type="text/javascript"></script>

</body>
</html>