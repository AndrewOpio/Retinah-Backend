<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$type = $obj['type'];
$email = $obj['email'];
//get user data to display in user profile

if($type == "email"){

  $check = "SELECT * FROM users WHERE email = '$email'";
  $send = mysqli_query($conn, $check);
  $get = mysqli_fetch_assoc($send);

  if($get){
    $random = rand(100, 100000);
    $subject = "Password Reset Code";
    mail($email, $subject, $random);

    $insert = "INSERT INTO reset VALUES ('$email', '$random')";
    $send = mysqli_query($conn, $send);

    if($send){
      echo json_encode("Sent");
    }else{
      echo json_encode('Error');
    }   

  } else{
      echo json_encode("Failed");
  }

}else if($type == "code"){
    $code = $obj['code'];
    $sql = "SELECT * FROM reset WHERE email = '$email' AND code = '$code'";
    $ex = mysqli_query($conn, $sql);

    $chk = mysqli_fetch_assoc($ex);
    if($chk){
    //Changing users' password to the code that was generated
    $update = "UPDATE Users SET Password = '$code' WHERE Email = '$email'";
    $run = mysqli_query($conn, $update); 

    //deleting code from database after confirmation
    $delete = "DELETE FROM reset WHERE email = '$email'";
    $execute = mysqli_query($conn, $delete);
    
    if($run){
      echo json_encode("Success");
   }else{
      echo json_encode('Error');
   } 
  }else{
    echo json_encode('Wrong');
  }  
  }
  
?>