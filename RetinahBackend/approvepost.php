<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$id = $obj['media'];

//Deleting posts from the database
$query = "UPDATE home SET approved = 'y' WHERE id = '$id'";
$run = mysqli_query($conn, $query);

if(!$run){
    echo json_encode("Error");
}else{
    echo json_encode('Done');
}     
?>       















