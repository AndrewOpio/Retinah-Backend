<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];

//get user data to display in user profile
if($email != ''){
$check = "SELECT * FROM users WHERE email = '$email'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
    echo json_encode($get, true);
}else if (!$get){
    echo json_encode($get.mysqli_error($conn));
}
}else{
    echo json_encode("empty");
}

?>