<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$fname = $obj['firstname'];
$lname = $obj['lastname'];
$contact = $obj['contact'];
$email = $obj['email'];
$gender = $obj['gender'];
$residence = $obj['residence'];
$estate = $obj['estate'];
$official = $obj['official'];
$password = $obj['password'];

//Validating and Logging in

$check = "SELECT * FROM users WHERE email = '$email'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
    echo json_encode('Failed');
}else{       
    $query = "INSERT INTO users (fname, lname, contact, email, gender, residence, password, propic, blocked, estate, official) VALUES ('$fname', '$lname', '$contact', '$email', '$gender', '$residence', '$password', '', 'n', '$estate', '$official')";
    $insert = mysqli_query($conn, $query);
    if(!$insert){
        echo json_encode("Error".mysqli_error($conn));
    }else{
        echo json_encode("Success");
    }
}        
?>       