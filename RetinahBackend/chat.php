<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

//Sending user messages to database
$messageid = $obj['messageid'];
$message = $obj['message'];
$period = $obj['period'];
$sender = $obj['sender'];
$receiver = $obj['receiver'];
$messagetype = $obj['messagetype'];
$lng = $obj['longitude'];
$lat = $obj['latitude'];
$time = date("h:i:sa");
$date = date("Y/m/d");
$circle = $obj['circle'];
$estate = $obj['estate'];

$query = "INSERT INTO chats (sender, receiver, messageid, message, messagetype, period, rd, date, time, lat, lng, circle, estate) VALUES ('$sender','$receiver', '$messageid','$message','$messagetype','$period', 1 ,'$date', '$time', '$lat', '$lng', '$circle', '$estate')";
$insert = mysqli_query($conn, $query);
if(!$insert){
    echo json_encode(mysqli_error($conn));
}else{
    echo json_encode("Registration Successful");
}
?>       











































