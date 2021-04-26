<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);
$email = $obj['email'];
$media = $obj['media'];

//Validating and Logging in

//$check = "SELECT * FROM users WHERE Email = '$email'";
//$send = mysqli_query($conn, $check);
//$get = mysqli_fetch_assoc($send);
   if($obj['color'] == "#000000"){
    $query = "INSERT INTO likes VALUES ('$email', '$media')";
    $insert = mysqli_query($conn, $query);
   }else{
    $query = "DELETE FROM likes WHERE email = '$email' AND id = '$media'";
    $delete = mysqli_query($conn, $query); 
   }
   
    $check = "SELECT * FROM home";
    $send = mysqli_query($conn, $check);

    
    while($get = mysqli_fetch_assoc($send)){

        $query = "SELECT * FROM comments WHERE id = '$get[id]'";
        $run = mysqli_query($conn, $query);
        $count = 0;
        while($retrieve = mysqli_fetch_assoc($run)){
            $count++;
        }
        $update = "UPDATE home set comments = '$count' WHERE id = '$get[id]'";
        $do = mysqli_query($conn, $update);
      }

    $check1 = "SELECT * FROM home ORDER BY id DESC";
    $send1 = mysqli_query($conn, $check1);
    $posts = array();
    $k = 0;    

    while($get1 = mysqli_fetch_assoc($send1)){
        //getting previous comment
        $lastcomment = "SELECT * FROM comments WHERE id = '$get1[id]'";
        $getlast = mysqli_query($conn, $lastcomment);
        $c = 0;
        $people = array();
        $comments = array();
        
        while($getarray = mysqli_fetch_assoc($getlast)){
          $people[$c] = $getarray['email'];
          $comments[$c] = $getarray['comment'];
          $c++;
        }
        if($c != 0){
          $index = $c-1;
          $person = $people[$index];

          $profile = "SELECT * FROM users WHERE email = '$person'";
          $exec = mysqli_query($conn, $profile);
          $user = mysqli_fetch_assoc($exec);
          
          $get1['lastpic'] = $user['propic'];
          $get1['lastfname'] = $user['fname'];
          $get1['lastlname'] = $user['lname'];
          $get1['lastmsg'] = $comments[$index];
        }

        //Checking for posts that the user has liked
        $likes = "SELECT * FROM likes WHERE email = '$email' AND id = '$get1[id]'";
        $execute = mysqli_query($conn, $likes);
        $confirm = mysqli_fetch_assoc($execute);

        if($confirm){
          $get1['like'] = "#ff33cc";
        }else{
          $get1['like'] = "#000000";
        }
        $lc = 0;
        $lcount = "SELECT * FROM likes WHERE id = '$get1[id]'";
        $lcrun = mysqli_query($conn, $lcount);

        while($lret = mysqli_fetch_assoc($lcrun)){
          $lc++;
        }
        $get1['lcount'] = $lc;
        
        $posts[$k] = $get1;
        $k++;
    }
    
    $profile = "SELECT * FROM users WHERE email = '$obj[email]'";
    $exec = mysqli_query($conn, $profile);
    $user = mysqli_fetch_assoc($exec);
    $pro = array();
    $pro[0] = $user;
    $bundle = array();
    $bundle[0] = $posts;
    $bundle[1] = $pro;

    if($bundle){
        echo json_encode($bundle, true);
    }else{
        echo json_encode('Error');
    }
    
?>       