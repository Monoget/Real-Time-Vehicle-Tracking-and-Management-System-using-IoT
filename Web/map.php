<!DOCTYPE html>
<html>
<head>
    <title>Google Map with Marker</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQiD8S2lGvDu_YwNxHvOCI1Ozp7n6DbH8&callback=initMap" async defer></script>
</head>
<body>
<div id="map" style="height: 700px; width: 100%;"></div>
<script>
    let map;
    let marker;

    function initMap() {
        let initialPosition = { lat: <?php echo $_GET['lat']; ?>, lng: <?php echo $_GET['long']; ?> };
        map = new google.maps.Map(document.getElementById('map'), {
            center: initialPosition,
            zoom: 15
        });

        // Custom marker icon
        let customIcon = {
            url: 'https://gps.monoget.com.bd/images/bus/kuet-bus-1.png',  // Specify the path to your custom icon image
            scaledSize: new google.maps.Size(50, 50),  // Adjust the size of the icon
        };

        marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            icon: customIcon  // Set the custom icon for the marker
        });
    }

    window.addEventListener('message', function(event) {
        if (event.data && event.data.action === 'changeMarkerPosition') {
            let newPosition = event.data.newPosition;
            marker.setPosition(newPosition);
        }
    });
</script>
</body>
</html>
