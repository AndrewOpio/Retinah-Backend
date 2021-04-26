<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);


$email = $obj['email'];
$district = $obj['district'];
$name = $obj['name'];
$contact = $obj['contact'];

//Adding an estate to the database

$check = "SELECT * FROM estates WHERE email = '$email'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
    echo json_encode('Failed');
}else{       
    $query = "INSERT INTO estates VALUES ( '$name', '$district', '$email',  '$contact')";
    $insert = mysqli_query($conn, $query);
    if(!$insert){
        echo json_encode("Error");
    }else{
        echo json_encode("Success");
    }
}        
?>       