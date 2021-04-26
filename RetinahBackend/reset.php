<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];

//get user data to display in user profile

$check = "SELECT * FROM Users WHERE Email = '$email'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
    echo json_encode($get, true);
}else{
    echo json_encode('Error');
}

?>











































