<?php
header('Content-Type: application/json');

// Get user location from POST request
$data = json_decode(file_get_contents('php://input'), true);
$userLat = $data['lat'];
$userLng = $data['lng'];

// Geofence center coordinates and radius
$geofenceLat = 40.74061; // Geofence center latitude
$geofenceLng = -73.935242; // Geofence center longitude
$radius = 1000; // Geofence radius in meters

// Function to calculate distance using the Haversine formula
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000; // Earth radius in meters

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos($lat1) * cos($lat2) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}

// Calculate the distance
$distance = haversineDistance($geofenceLat, $geofenceLng, $userLat, $userLng);

// Check if the user is inside the geofence
if ($distance <= $radius) {
    echo json_encode("Inside Geofence");
} else {
    echo json_encode("Outside Geofence");
}
?>
