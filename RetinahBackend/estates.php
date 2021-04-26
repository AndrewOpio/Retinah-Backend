<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$email = $obj['email'];

//Getting estates
$query = "SELECT * FROM estates";
$run = mysqli_query($conn, $query);
$estates = array();
$i = 0;

while($get = mysqli_fetch_assoc($run)){
  $estates[$i] = $get; 
  $i++;
}


if(!$estates){
    echo json_encode("Error");
}else{
    echo json_encode($estates, true);
}     
?>       

























































































