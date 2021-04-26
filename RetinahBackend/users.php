<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$search = $obj['search'];

//hValidating and Logging in
    if($search == ''){

        $query = "SELECT * FROM users";
        $insert = mysqli_query($conn, $query);

        $users = array();
        $i = 0;

        while($get = mysqli_fetch_assoc($insert)){
            if($obj['admin'] == ""){
              $email = $obj['email'];

              $req = "SELECT * FROM circle WHERE (sender = '$email' AND receiver = '$get[email]') OR (receiver = '$email' AND sender = '$get[email]')";
            }else{
              $req = "SELECT * FROM circle";
            }
            $send = mysqli_query($conn, $req); 
            $br = mysqli_fetch_assoc($send);
            if($br){
                $get['status'] = $br['status'];
            }else{
                $get['status'] = "";
            }

            $users[$i] = $get;
            $i++;
        }
        if(!$users){
            echo json_encode("Error".$contact);
        }else{
            echo json_encode($users, true);
        }     
        
    }else{
        $contact = $obj['contact'];

        $query = "SELECT * FROM users WHERE contact = '$contact'";
        $insert = mysqli_query($conn, $query);
        $get = mysqli_fetch_assoc($insert);
        $get['id'] = 0;
        if(!$get){
            echo json_encode("Error".$contact);
        }else{
            echo json_encode($get, true);
        }     
    }
    
?>       















