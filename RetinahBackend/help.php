<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$id = $obj['id'];
//Retrieving data for homescreen and commnents

if($obj['id'] == "hospitals"){
  $check = "SELECT * FROM hospitals WHERE district = '$obj[location]'";
  $send = mysqli_query($conn, $check);
  $get = mysqli_fetch_all($send, MYSQLI_ASSOC);

  if($get){
    echo json_encode($get);
  }else{
    echo json_encode('System Error');
  }

}else if($obj['id'] == "contacts"){
  $type = $obj['type'];

  if($type == "tollfreelines"){
    
    $check1 = "SELECT * FROM contacts WHERE type = '$type'";
    $send1 = mysqli_query($conn, $check1);
    $get1 = mysqli_fetch_all($send1, MYSQLI_ASSOC);
    
    if($get1){
      echo json_encode($get1, true);
    }else{
      echo json_encode('Error');
    }
  }else if($type == "ambulances"){

    $check1 = "SELECT * FROM contacts WHERE type = '$type'";
    $send1 = mysqli_query($conn, $check1);
    $get1 = mysqli_fetch_all($send1, MYSQLI_ASSOC);

    if($get1){
      echo json_encode($get1, true);
    }else{
      echo json_encode('Error');
    }
  }
}
?>