<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$sender = $obj['sender'];
$receiver = $obj['receiver'];

//hValidating and Logging in
    $query = "SELECT * FROM chats WHERE (sender = '$sender' AND receiver = '$receiver') OR (receiver = '$sender' AND sender = '$receiver')";
    $insert = mysqli_query($conn, $query);
    $get = mysqli_fetch_all($insert, MYSQLI_ASSOC);
    
    $update = "UPDATE chats SET rd = 0 WHERE receiver = '$sender' AND sender = '$receiver'";
    $run = mysqli_query($conn, $update);
    
    if(!$get){
        echo json_encode("Error");
    }else{
        echo json_encode($get, true);
    }     
?>       















