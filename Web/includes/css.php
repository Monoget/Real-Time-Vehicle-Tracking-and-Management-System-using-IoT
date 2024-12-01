<?php
if(!isset($_SESSION["user_id"])){
    echo "<script>
                window.location.href='Login';
                </script>";
}
?>
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
<link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Datatable -->
<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
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