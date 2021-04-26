<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$id = $obj['id'];
//Retrieving data for homescreen and commnents

if($id == "home"){
  $category = $obj['category'];
  $email = $obj['email'];

    $check = "SELECT * FROM home";    
    $send = mysqli_query($conn, $check);
 
    while($get = mysqli_fetch_assoc($send)){
        $query = "SELECT * FROM comments WHERE id = '$get[id]'";
        $run = mysqli_query($conn, $query);
        $cnt = 0;
        while($retrieve = mysqli_fetch_assoc($run)){
            $cnt++;
        }


        //Rounding up comment figures
        $str = strval($cnt);

        if($cnt > 999 && $cnt < 10000 ){
          $count = $str[0]."k";
          $update = "UPDATE home set comments = '$count' WHERE id = '$get[id]'";
          $do = mysqli_query($conn, $update);
  
        }else if($cnt > 9999 && $cnt < 100000 ){
          $count = $str[0].$str[1]."k";
          $update = "UPDATE home set comments = '$count' WHERE id = '$get[id]'";
          $do = mysqli_query($conn, $update);
  
        }else if($cnt > 99999 && $cnt < 1000000 ){
          $count = $str[0].$str[1].$str[2]."k";
          $update = "UPDATE home set comments = '$count' WHERE id = '$get[id]'";
          $do = mysqli_query($conn, $update);
  
        }else{
          $update = "UPDATE home set comments = '$cnt' WHERE id = '$get[id]'";
          $do = mysqli_query($conn, $update);
        }

    }

    if($category == "all"){
      $check1 = "SELECT * FROM home WHERE approved = 'y' ORDER BY id DESC";

    }else if($category == "missing"){
      $check1 = "SELECT * FROM home WHERE category = '$category' AND approved = 'y' ORDER BY id DESC";

    }else if($category == "lost"){
      $check1 = "SELECT * FROM home WHERE category = '$category' AND approved = 'y' ORDER BY id DESC";
    
    }else if($category == "approve"){
      $check1 = "SELECT * FROM home WHERE approved = 'n' ORDER BY id DESC";
    }

    $send1 = mysqli_query($conn, $check1);
    $posts = array();
    $k = 0;    

    while($get1 = mysqli_fetch_assoc($send1)){

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

         //Rounding up comment figures
         $str1 = strval($lc);

         if($lc > 999 && $lc < 10000 ){
           $lc1 = $str1[0]."k";
           $get1['lcount'] = $lc1;

         }else if($lc > 9999 && $lc < 100000 ){
           $lc1 = $str1[0].$str1[1]."k";
           $get1['lcount'] = $lc1;

         }else if($lc > 99999 && $lc < 1000000 ){
           $lc1 = $str1[0].$str1[1].$str1[2]."k";
           $get1['lcount'] = $lc1;

         }else{
          $get1['lcount'] = $lc;
         }

      
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
        
        //Get user who uploaded a given post
        $sender = "SELECT * FROM users WHERE email = '$get1[email]'";
        $exe = mysqli_query($conn, $sender);
        $id = mysqli_fetch_assoc($exe);
        
        $get1['pic'] = $id['propic'];
        $get1['fname'] = $id['fname'];
        $get1['lname'] = $id['lname'];

        $posts[$k] = $get1;

        $k++;
    }
    
    // $profile = "SELECT * FROM users WHERE email = '$obj[email]'";
    //$exec = mysqli_query($conn, $profile);
    //$user = mysqli_fetch_assoc($exec);

    $bundle = array();
    $bundle[0] = $posts;
    //$bundle[1] = $user;

    if($bundle){
        echo json_encode($bundle, true);
    }else{
        echo json_encode('Error'.mysqli_error($conn));
    }

}else if($id == "comments"){

    if($obj['insert'] == "yes"){
      $time = date("h:i:sa");
      $date = date("Y/m/d"); 
      $insert = "INSERT INTO comments (time, comment, id, date, email , sent_by) VALUES ('$time', '$obj[comment]', '$obj[media_id]', '$date', '$obj[email]', '$obj[user]')";
      $push = mysqli_query($conn, $insert);
       if ($push){     
        $media_id = $obj['media_id']; 
        $check2 = "SELECT * FROM comments WHERE id = '$media_id' ORDER BY commentId DESC";
        $send2 = mysqli_query($conn, $check2);

        $comments = array();
        $i = 0;

        while($get2 = mysqli_fetch_assoc($send2)){
          $bring = "SELECT * FROM users WHERE email = '$get2[email]'";
          $yes = mysqli_query($conn, $bring);
          $conf = mysqli_fetch_assoc($yes);
          $get2['fname'] = $conf['fname'];
          $get2['lname'] = $conf['lname'];
          $get2['propic'] = $conf['propic'];
          $comments[$i] = $get2;
          $i++;
        }
        if($comments){
          echo json_encode($comments, true);
        }else{
          echo json_encode('Error');
        }
     }else{
         echo json_encode('Error');
     }

    }else{
        $media_id = $obj['media_id'];
        $check2 = "SELECT * FROM comments WHERE id = '$media_id' ORDER BY commentId DESC";
        $send2 = mysqli_query($conn, $check2);
        //$get2 = mysqli_fetch_all($send2, MYSQLI_ASSOC);

        $coments = array();
        $i = 0;

        while($get2= mysqli_fetch_assoc($send2)){
          $bring = "SELECT * FROM users WHERE email = '$get2[email]'";
          $yes = mysqli_query($conn, $bring);
          $conf = mysqli_fetch_assoc($yes);
          $get2['fname'] = $conf['fname'];
          $get2['lname'] = $conf['lname'];
          $get2['propic'] = $conf['propic'];
          $coments[$i] = $get2;
          $i++;
        }
        if($coments){
          echo json_encode($coments, true);
        }else{
          echo json_encode('Error');
        }
     }
   }
?>