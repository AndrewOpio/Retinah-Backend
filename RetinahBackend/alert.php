<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];

//Getting users in one's circle
$circle = array();
$i = 0;
$query = "SELECT * FROM circle WHERE (sender = '$email' OR receiver = '$email') AND status = 'connected'";
$run = mysqli_query($conn, $query);

while($get = mysqli_fetch_assoc($run)){
    if($get['sender'] != $email ){
        $circle[$i] = $get['sender']; 

    }else if($get['receiver'] != $email){
        $circle[$i] = $get['receiver']; 
    }
    $i++;
}

if(!$circle){
    echo json_encode("Error");
}else{
    echo json_encode($circle, true);
}     
?>       

























































































