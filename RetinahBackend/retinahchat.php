<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];

//get user data to display in user profile
if($email != ''){

//Selecting and arranging messages in order of the latest message sent by the sender or reciever
    $retinah = "SELECT * FROM retinah";
    $qri = mysqli_query($conn, $retinah);
    $qryret = mysqli_fetch_assoc($qri);
    
    //$sent = array();
   // $i = 0;
  
    $mes = array();
    $time = array();
    $k = 0;
    $m = 0;
    $last = "SELECT * FROM chats WHERE (sender = '$qryret[email]' AND receiver = '$email') OR (sender = '$email' AND receiver = '$qryret[email]')";
    $exec = mysqli_query($conn, $last);
    while ($ret = mysqli_fetch_assoc($exec)){
      if($ret['message'] != '' && $ret['rd'] == 1 && $ret['receiver'] == $email){
        $k++;
        }
        
      if($ret['messagetype'] == "text"){
        $mes[$m] = $ret['message'];
      }else if($ret['messagetype'] == "image"){
        $mes[$m] = "image attachment";
      }else if($ret['messagetype'] == "video"){
        $mes[$m] = "video attachment";
      }else if($ret['messagetype'] == "audio"){
        $mes[$m] = "audio attachment";
      }
      
      $dt = date("Y/m/d"); 
      $name = "date";
      $upd = "UPDATE date SET date = '$dt' WHERE name = '$name'";
      $updrun = mysqli_query($conn, $upd);

      $dte = "SELECT * FROM date";
      $sqli = mysqli_query($conn, $dte);
      $bringing = mysqli_fetch_assoc($sqli); 

      if($ret['date'] ==  $bringing['date']){
        $time[$m] = $ret['time'];
      }else{
        $time[$m] = $ret['date'];
      }
      $m++;
    }
    $count = $m;
    if($count == 0){
      $index = $count; 
      $tm = "";
      $text = "";
    }else{
      $index = $count-1;
      $tm = $time[$index];
      $text = $mes[$index];  
    }
       
    $qryret['msg'] = $text;
    $qryret['count'] = $k;
    $qryret['time'] = $tm;
  }


if($qryret){
    echo json_encode($qryret, true);
}else if (!$qryret){
    echo json_encode(mysqli_error($conn));
}

?>



























































































