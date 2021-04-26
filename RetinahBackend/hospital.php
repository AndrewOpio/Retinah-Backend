<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);


$name = $obj['name'];
$email = $obj['email'];
$contact = $obj['contact'];
$location = $obj['location'];
$latitude = $obj['latitude'];
$longitude = $obj['longitude'];
$password = $obj['password'];

//Validating and Logging in

$check = "SELECT * FROM hospitals WHERE email = '$email'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
    echo json_encode('Failed');
}else{       
    $query = "INSERT INTO hospitals (name, email, contact, lat, lng, district, password, logo) VALUES ('$name', '$email', '$contact', '$latitude', '$longitude', '$location', '$password', '')";
    $insert = mysqli_query($conn, $query);
    if(!$insert){
        echo json_encode("Error");
    }else{
        echo json_encode("Success");
    }
}        
?>       