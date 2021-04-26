<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$estate = $obj['estate'];
$messageid = $obj['messageid'];
$message = $obj['message'];
$period = $obj['period'];
$sender = $obj['email'];
$messagetype = $obj['messagetype'];
$lng = $obj['longitude'];
$lat = $obj['latitude'];
$time = date("h:i:sa");
$date = date("Y/m/d");
$circle = $obj['circle'];

//Retrieving data for homescreen and commnents


$check = "SELECT * FROM chats WHERE sender = '$sender' AND estate != ''";
$send = mysqli_query($conn, $check);

while($get = mysqli_fetch_assoc($send)){     
  $filter = "SELECT * FROM chats WHERE sender = '$get[sender]' AND receiver = '$get[receiver]'";
  $sieve = mysqli_query($conn, $filter);

  $count = 0; 

  while($grab = mysqli_fetch_assoc($sieve)){
    $count++;
  }

  if($count == 1){
    $delete = "DELETE FROM chats WHERE sender = '$get[sender]' AND receiver = '$get[receiver]'";
    $run = mysqli_query($conn, $delete);
  }
}

$query = "SELECT * FROM users WHERE estate ='$estate' AND official = 'true'";
$run = mysqli_query($conn, $query);

while($res = mysqli_fetch_assoc($run)){
  $sql = "INSERT INTO chats (sender, receiver, messageid, message, messagetype, period, rd, date, time, lat, lng, circle, estate) VALUES ('$sender','$res[email]', '$messageid','$message','$messagetype','$period', 1 ,'$date', '$time', '$lat', '$lng', '$circle', '$estate')";
  $insert = mysqli_query($conn, $sql);
  
  if($insert){
    echo json_encode("Done");
  }else{
    echo json_encode('System Error');
  }
  
}

if($get){
  echo json_encode($get);
}else{
  echo json_encode('System Error');
}

?>