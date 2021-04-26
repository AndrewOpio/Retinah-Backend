<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];
$password = $obj['password'];

//Validating and Logging in

if($obj['email'] != "" && $obj['password'] != ""){
    
    $check = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
    $send = mysqli_query($conn, $check);
    $get = mysqli_fetch_assoc($send);
    
    if(!$get){
        $check1 = "SELECT * FROM police WHERE Email = '$email' AND Password = '$password'";
        $send1 = mysqli_query($conn, $check1);
        $get1 = mysqli_fetch_assoc($send1);
        if(!$get1){
           $check2 = "SELECT * FROM retinah WHERE Email = '$email' AND Password = '$password'";
           $send2 = mysqli_query($conn, $check2);
           $get2 = mysqli_fetch_assoc($send2);

           if(!$get2){
                $check3 = "SELECT * FROM hospitals WHERE Email = '$email' AND Password = '$password'";
                $send3 = mysqli_query($conn, $check3);
                $get3 = mysqli_fetch_assoc($send3);
    
                if($get3){
                   echo json_encode('Hospital');
                }else{
                   echo json_encode('Failed');
                }

            }else{
                if($get2){
                    echo json_encode('Retinah');
                }else{
                    echo json_encode('Failed');
                }
            }

        }else{
            if($get1){
                echo json_encode('Police');
            }else{
                echo json_encode('Failed');
            }
        }
    
    }else{
       if($get){
          if($get['blocked'] == "n"){
              if($get['official'] == "true"){
                echo json_encode('Estate');
              }else{
                echo json_encode('Citizen');
              }
          }else{
            echo json_encode('Blocked');
          }
        }else{
        echo json_encode('Failed');
      }
   }
}
?>
