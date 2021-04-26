<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$delete = $obj['delete'];

//admin blocking, unblocking and deleting users
if($delete == ''){
    $email = $obj['email'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $run = mysqli_query($conn, $query);
    $get = mysqli_fetch_assoc($run);
    
    if($get['blocked'] == "n"){
      $update = "UPDATE users SET blocked = 'y' WHERE email = '$email'";
      $execute = mysqli_query($conn, $update);
      if(!$execute){
        echo json_encode("Error");
      }else{
        echo json_encode("Done".mysqli_error($conn));
      }     
    }else {
      $update = "UPDATE users SET blocked = 'n' WHERE email = '$email'";
      $execute = mysqli_query($conn, $update);
      if(!$execute){
        echo json_encode("Error");
      }else{
        echo json_encode("Done");
      }     
    }
}else{
    $email = $obj['email'];

    $query = "DELETE  FROM users WHERE email = '$email'";
    $run = mysqli_query($conn, $query);
    if(!$run){
        echo json_encode("Error");
    }else{
        echo json_encode("Done");
    }     
}

?>       















