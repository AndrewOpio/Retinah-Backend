<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);
$dir="propics/";
$image = $_FILES['propic'];
$image_name=$image['name'];
$image_tmp=$image['tmp_name'];

$dir="propics/";
move_uploaded_file($image_tmp,$dir.$image_name);
$uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/propics/";
$propic = $uri.$image_name;
$query = "UPDATE users SET propic = '$propic' WHERE email = '$_POST[email]'";
$run = mysqli_query($conn, $query);

$check = "SELECT * FROM users WHERE email = '$_POST[email]'";
$send = mysqli_query($conn, $check);
$get = mysqli_fetch_assoc($send);

if($get){
  echo json_encode($get, true);
}else{
  echo json_encode('Failed');
}

?>
