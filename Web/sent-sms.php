<?php
session_start();
require_once("includes/dbController.php");
$db_handle = new DBController();

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $latitude=$_GET['latitude'];
    $longitude=$_GET['longitude'];

    $query = "SELECT * FROM vehicle where id='$id' order by id desc";
    $data = $db_handle->runQuery($query);

    $number=$data[0]['driver_number'];

    $url = 'https://app.smsnoc.com/api/http/sms/send';


    $data = array(
        'api_token' => '187|9F3gntgqbEyU30jkJckcUB2tc3hLybGmktKNMp1s18cfeafb ',
        'recipient' => '88' . $number,
        'sender_id' => '8809617611301',
        'type' => 'plain',
        'message' => 'Your passenger wait in this location visit this url for see user location https://maps.google.com/maps?q='.$_GET['latitude'].','.$_GET['longitude'].'&hl=en&z=20 please be quick and pickup him.'
    );

    $postData = json_encode($data);

    $ch = curl_init($url);

    $headers = array(
        'Content-Type: application/json',
        'Accept: application/json'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'failed';
    }else{
        echo 'success';
    }
}

