<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$search = $obj['text'];

//get user data to display in user profile

$check = "SELECT * FROM contacts WHERE name = '$search'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_all($send, MYSQLI_ASSOC);

if($get){
    echo json_encode($get, true);
}else{
    echo json_encode('Error');
}

?>