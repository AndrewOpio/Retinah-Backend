<?php
    include 'connect.php';

    $json = file_get_contents('php://input');
    $obj  = json_decode($json, true);

    $email = $obj['email'];

    //get user data to display in user profile
    if($obj['edit'] != ""){
      if($obj['firstname'] != ''){
        $update = "UPDATE users SET fname = '$obj[firstname]' WHERE email ='$obj[email]'";
        $go = mysqli_query($conn, $update);
      }
      if($obj['lastname'] != ''){
        $update1 = "UPDATE users SET lname = '$obj[lastname]' WHERE email ='$obj[email]'";
        $go1 = mysqli_query($conn, $update1);
      }
      if($obj['email'] != ''){
        $update2 = "UPDATE users SET email = '$obj[email]' WHERE email ='$obj[email]'";
        $go2 = mysqli_query($conn, $update2);
      }
      if($obj['gender'] != ''){
        $update3 = "UPDATE users SET gender = '$obj[gender]' WHERE email ='$obj[email]'";
        $go3 = mysqli_query($conn, $update3);
      }
      if($obj['residence'] != ''){
        $update4 = "UPDATE users SET residence = '$obj[residence]' WHERE email ='$obj[email]'";
        $go4 = mysqli_query($conn, $update4);
      }
      if($obj['estate'] != ''){
        $update5 = "UPDATE users SET estate = '$obj[estate]' WHERE email ='$obj[email]'";
        $go5 = mysqli_query($conn, $update5);
      }
      if($obj['contact'] != ''){
        $update6 = "UPDATE users SET contact = '$obj[contact]' WHERE email ='$obj[email]'";
        $go6 = mysqli_query($conn, $update6);
      }
      echo json_encode("Success");
    }else{
      $check = "SELECT * FROM users WHERE email = '$email'";
      $send = mysqli_query($conn, $check);
      $get = mysqli_fetch_assoc($send);

      if($get){
          echo json_encode($get, true);
      }else{
          echo json_encode('Error'+ mysqli_error($conn));
      }
    }
?>












































