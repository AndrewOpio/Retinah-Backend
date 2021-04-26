<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];
$user = $obj['user'];

//get user data to display in user profile
if($email != ''){

//Selecting and arranging messages in order of the latest message sent by the sender or reciever
$check = "SELECT * FROM chats WHERE receiver = '$email' OR sender = '$email' ORDER BY id DESC";
$send = mysqli_query($conn, $check);

 if($send){
    $del = "DELETE FROM newmessages";
    $ete = mysqli_query($conn, $del);
    
    //Selecting from the police table
    $police = "SELECT * FROM police";
    $qry = mysqli_query($conn, $police);
    $qryrun = mysqli_fetch_assoc($qry);
    
    //Selecting from the retinah table
    $retinah = "SELECT * FROM retinah";
    $retnah = mysqli_query($conn, $retinah);
    $retn = mysqli_fetch_assoc($retnah);

    $sent = array();
    $i = 0;

    while($get = mysqli_fetch_assoc($send)){
      
      $check2 = "SELECT * FROM newmessages WHERE (receiver = '$get[receiver]' AND sender = '$get[sender]') OR (sender = '$get[receiver]' AND receiver = '$get[sender]')";
      $try = mysqli_query($conn, $check2);
      $tried = mysqli_fetch_assoc($try);

      if(!$tried){
        if(($get['sender'] == $email && $get['receiver'] != $qryrun['email']) && ($get['sender'] == $email && $get['receiver'] != $retn['email'])){
          
          //Checking for communication between estate personnel and other citizens
          if($get['estate'] != ""){
            $stmt = "SELECT * FROM chats WHERE sender = '$get[sender]' AND receiver = '$get[receiver]'";
            $runestate = mysqli_query($conn, $stmt);
            $num = 0;

            while($estate = mysqli_fetch_assoc($runestate)){
              $num ++;
            }

            if($num == 1 && $user != "estate"){

              /*if a citizen has not sent more than one message he 
              is the only one who sees it but not the estate personnel*/

              $add = "INSERT INTO newmessages VALUES('$get[sender]','$get[receiver]')";
            }else if($num > 1){
              $add = "INSERT INTO newmessages VALUES('$get[sender]','$get[receiver]')";
            }

          }else{
            $add = "INSERT INTO newmessages VALUES('$get[sender]','$get[receiver]')";
          }

          $conf = mysqli_query($conn, $add);
        }else if(($get['receiver'] == $email && $get['sender'] != $qryrun['email']) && ($get['receiver'] == $email && $get['sender'] != $retn['email'])){
          $add = "INSERT INTO newmessages VALUES('$get[receiver]','$get[sender]')";
          $conf = mysqli_query($conn, $add);
        }
      }
    }
 
    $final = "SELECT * FROM newmessages WHERE receiver = '$email' OR sender ='$email'";
    $getfinal = mysqli_query($conn, $final);
    if($getfinal){
      while($req = mysqli_fetch_assoc($getfinal)){
        $mes = array();
        $time = array();
        $k = 0;
        $m = 0;
        $last = "SELECT * FROM chats WHERE (sender = '$req[sender]' AND receiver = '$req[receiver]') OR (sender = '$req[receiver]' AND receiver = '$req[sender]')";
        $exec = mysqli_query($conn, $last);
        while ($ret = mysqli_fetch_assoc($exec)){
        if($ret['message'] != '' && $ret['rd'] == 1 && $ret['receiver'] == $email){
          $k++;
         }
         
         $estate = $ret['estate'];

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

        if($ret['date'] == $bringing['date']){
          $time[$m] = $ret['time'];
        }else{
          $time[$m] = $ret['date'];
        }
          $m++;
        }

        $count = $m;

        if($count == 0){
          $tm = "";
          $text = "";
        }else{
          $index = $count-1;
          $text = $mes[$index];
          $tm = $time[$index];
        }

        if($req['sender'] != $email){
            $check1 = "SELECT * FROM users WHERE email = '$req[sender]'";
            $send1 = mysqli_query($conn, $check1); 
            $get1 = mysqli_fetch_assoc($send1);
            
            if(!$get1){
              $selekt = "SELECT * FROM hospitals WHERE email = '$req[sender]'";
              $qweri = mysqli_query($conn, $selekt); 
              $drop = mysqli_fetch_assoc($qweri);
              $drop['id'] = $i;
              $drop['msg'] = $text;
              $drop['count'] = $k;
              $drop['time'] = $tm;
              $drop['identity'] = "hospital";
              $sent[$i] = $drop;
            }else{
              $get1['id'] = $i;
              $get1['msg'] = $text;
              $get1['count'] = $k;
              $get1['time'] = $tm;
              $get1['identity'] = "citizen";
              $get1['estate'] = $estate;
              $sent[$i] = $get1;
           }
         }else{
            $check1 = "SELECT * FROM users WHERE email = '$req[receiver]'";
            $send1 = mysqli_query($conn, $check1); 
            $get1 = mysqli_fetch_assoc($send1); 
            if(!$get1){
              $selekt = "SELECT * FROM hospitals WHERE email = '$req[receiver]'";
              $qweri = mysqli_query($conn, $selekt); 
              $drop = mysqli_fetch_assoc($qweri);
              $drop['id'] = $i;
              $drop['msg'] = $text;
              $drop['count'] = $k;
              $drop['time'] = $tm;
              $drop['identity'] = "hospital";
              $sent[$i] = $drop;
            }else{  
              $get1['id'] = $i;
              $get1['msg'] = $text;
              $get1['count'] = $k;
              $get1['time'] = $tm;
              $get1['identity'] = "citizen";
              $get1['estate'] = $estate;
              $sent[$i] = $get1;
            }
         }
        $i++;
      }
    }

if($sent){
    echo json_encode($sent, true);
}else if (!$sent){
    echo json_encode("Failed");
}
}
}else{
    echo json_encode("empty");
}

?>