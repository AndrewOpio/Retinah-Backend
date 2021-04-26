<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$change = $obj['change'];
$email = $obj['email'];

//Changing password
if($change != ""){

  $old = $obj['old'];
  $new = $obj['new'];

  $check = "SELECT * FROM users WHERE Email = '$email' AND Password = '$old'";
  $send = mysqli_query($conn, $check);
  $get = mysqli_fetch_assoc($send);

  if($get){
    $update = "UPDATE users SET Password = '$new' WHERE Email = '$email'";
    $run = mysqli_query($conn, $update);
    if($run){
      echo json_encode("Success");
    }
  }else{
      echo json_encode('Error');
  }
}else{
  
  $check = "SELECT * FROM users WHERE Email = '$email'";
  $send = mysqli_query($conn, $check);
  $get = mysqli_fetch_assoc($send);
  
  if($get){
    echo json_encode($get, true);
  }else{
    echo json_encode('Error');
  }
}
?>