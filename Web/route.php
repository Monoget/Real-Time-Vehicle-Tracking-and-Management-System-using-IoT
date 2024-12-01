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
    <title>Route | GPS Tracker</title>
    <!-- Favicon icon -->
    <?php require_once('includes/css.php'); ?>
    <style>
        #map{
            height: 600px;
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
                    <div id="map">
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQiD8S2lGvDu_YwNxHvOCI1Ozp7n6DbH8&callback=initMap" type="text/javascript"></script>
<?php require_once('includes/js.php'); ?>
<script>
    x = navigator.geolocation;

    x.getCurrentPosition(success, failure);

    function success(position)

    {
        let myLat = position.coords.latitude;
        let myLong = position.coords.longitude;

        //alert(myLat);

        let coords = new google.maps.LatLng(myLat,myLong);

        let mapOptions = {

            zoom:15,
            center: coords,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        let map = new google.maps.Map(document.getElementById("map"), mapOptions);
        let marker = new google.maps.Marker({map:map, position:coords});
    }

    function failure(){ }

</script>
</body>
</html>