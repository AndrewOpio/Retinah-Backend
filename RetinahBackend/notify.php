<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$title = $obj['title'];
$message = $obj['message'];
$link = $obj['link'];
$code = $obj['code'];
$time = date("h:i:sa");
$date = date("Y/m/d"); 
$location = $obj['location'];
$to = $obj['to'];
//Inserting into home
    $query = "INSERT INTO notifications (time, location, code, message, date, title, Sent_To) VALUES ('$time','$location', '$code','$message','$date', '$title', '$to')";
    $insert = mysqli_query($conn, $query);
    if(!$insert){
        echo json_encode(mysqli_error($conn));
    }else{
        echo json_encode("Inserted");
    }
?>       






































































































































