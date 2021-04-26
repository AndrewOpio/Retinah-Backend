<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$id = $obj['media'];

//Deleting posts from the database
$query = "DELETE FROM home WHERE id = '$id'";
$delete = mysqli_query($conn, $query);

if(!$delete){
    echo json_encode("Error");
}else{
    echo json_encode('Done');
}     
?>       















