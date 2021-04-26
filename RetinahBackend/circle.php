<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);


if($obj['status'] == "insert"){
  $sender = $obj['sender'];
  $receiver = $obj['receiver'];
  $query = "INSERT INTO circle VALUES ('$sender','$receiver', 'pending')";
  $insert = mysqli_query($conn, $query);
  if(!$insert){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode("Sent");
  }

}else if($obj['status'] == "accepted"){
  $email = $obj['email'];
  $query = "SELECT * FROM circle WHERE (sender = '$email' AND (status = 'pending' OR status = 'connected')) OR (receiver = '$email' AND status = 'connected')";
  $play = mysqli_query($conn, $query);

  $email = $obj['email'];
  $pending = array();
  $i = 0;
  
  while($grab = mysqli_fetch_assoc($play)){
    if($grab['sender'] == $email){
      $user = "SELECT * FROM users WHERE email = '$grab[receiver]'";
    }else{
      $user = "SELECT * FROM users WHERE email = '$grab[sender]'";
    }
    $ex = mysqli_query($conn, $user);
    $catch = mysqli_fetch_assoc($ex);
    $catch['status'] = $grab['status'];
    $pending[$i] = $catch;
    $i++;  
  }

  if(!$pending){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode($pending, true);
  }
  

}else if($obj['status'] == "pending"){
  $email = $obj['email'];
  $pending = array();
  $i = 0;
  $query = "SELECT * FROM circle WHERE receiver = '$email' AND status = 'pending'";
  $play = mysqli_query($conn, $query);

  while($grab = mysqli_fetch_assoc($play)){
    $user = "SELECT * FROM users WHERE email = '$grab[sender]'";
    $ex = mysqli_query($conn, $user);
    $catch = mysqli_fetch_assoc($ex);
    $catch['status'] = $grab['status'];
    $pending[$i] = $catch;
    $i++;  
  }

  if(!$pending){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode($pending, true);
  }

}else if($obj['status'] == "accept"){
  $query = "UPDATE circle SET status = 'connected' WHERE sender = '$obj[sender]' AND receiver = '$obj[receiver]'";
  $update = mysqli_query($conn, $query);
  if(!$update){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode("Done");
  }

}else if($obj['status'] == "decline"){
  $query = "DELETE FROM circle  WHERE sender = '$obj[sender]' AND receiver = '$obj[receiver]'";
  $update = mysqli_query($conn, $query);
  if(!$update){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode("Done");
  }

}else if($obj['status'] == "cancel"){
  $query = "DELETE FROM circle  WHERE sender = '$obj[sender]' AND receiver = '$obj[receiver]'";
  $update = mysqli_query($conn, $query);
  if(!$update){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode("Done");
  }

}else if($obj['status'] == "remove"){
  $query = "DELETE FROM circle  WHERE (sender = '$obj[sender]' AND receiver = '$obj[receiver]') OR (sender = '$obj[receiver]' AND receiver = '$obj[sender]')";
  $update = mysqli_query($conn, $query);
  if(!$update){
    echo json_encode(mysqli_error($conn));
  }else{
    echo json_encode("Done");
  }
}
?>       







































































































