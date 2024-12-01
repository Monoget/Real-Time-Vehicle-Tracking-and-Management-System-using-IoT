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
    <title>Bus Live Location | GPS Tracker</title>
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
                <div class="col-lg-12 mt-5 text-right">
                    <button onclick="getLocation()" type="button" class="btn btn-info"><i
                                class="fa fa-telegram" aria-hidden="true"></i> Notify Driver
                    </button>
                </div>
                <div class="col-12 mt-5">
                    <?php if (isset($_GET['lat'])) {
                        ?>
                        <div id="map-container">
                            <iframe width="100%" height="700" id="map-frame" src="map.php?lat=<?php echo $_GET['lat']; ?>&long=<?php echo $_GET['lan']; ?>"></iframe>
                        </div>
                        <?php
                    } ?>
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


<script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(visitorLocation);
        } else {
            console.log('This browser does not support Geolocation Service.');
        }
    }

    function visitorLocation(position) {
        let lat = position.coords.latitude;
        let long = position.coords.longitude;
        $.ajax({
            type: 'get',
            url: 'sent-sms.php',
            data: 'latitude=' + lat + '&longitude=' + long+'&id=<?php echo $_GET['id']; ?>',
            success: function (response) {
                toastr.success("Sms sent successful", "Successful", {
                    timeOut: 3000,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    positionClass: "toast-bottom-right",
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    iconClass: "toast-success",
                    tapToDismiss: !1
                })
            }
        });

        $.ajax({
            type: 'get',
            url: 'send-passenger-location.php',
            data: 'latitude=' + lat + '&longitude=' + long+'&id=<?php echo $_GET['id']; ?>',
            success: function (address) {
                toastr.success("Location sent to driver", "Successful", {
                    timeOut: 3000,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    positionClass: "toast-bottom-right",
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    iconClass: "toast-success",
                    tapToDismiss: !1
                })
            }
        });
    }

    function updateMap() {

        // Wait for the iframe content to load
        window.addEventListener('load', function() {
            // Get the iframe element

        });



        $.ajax({
            url: 'refresh-map.php?id=<?php echo $_GET['id']; ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                console.log('Received data:', data);

                let mapFrame = document.getElementById('map-frame');
                let mapContentWindow = mapFrame.contentWindow || mapFrame.contentDocument;

                if (mapContentWindow) {
                    function changeMarkerPosition() {
                        let newMarkerPosition = {
                            lat: parseFloat(data.lat),
                            lng: parseFloat(data.lng)
                        };
                        mapContentWindow.postMessage({
                            action: 'changeMarkerPosition',
                            newPosition: newMarkerPosition
                        }, '*');
                    }

                    changeMarkerPosition();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ' + textStatus, errorThrown);
            }
        });
    }

    updateMap();

    setInterval(function() {
        updateMap();
    }, 1000);
</script>

</body>
</html>