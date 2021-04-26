<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

//$email =  $obj['email'];
//$delete_id = $obj['delete_id'];
//$id = $obj['id'];

//getting notifications according to current district
if( $obj['delete_id'] != "" ){

 $query = "INSERT INTO deleted VALUES ('$obj[id]','$obj[email]')";
 $insert = mysqli_query($conn, $query);

    if($insert){
    $district = $obj['district'];
    $check = "SELECT * FROM notifications ORDER BY id DESC ";
    $send = mysqli_query($conn, $check);
 if($send){
    $data = array();
    $i = 0;

    while($array = mysqli_fetch_assoc($send)){
        $del = "SELECT * FROM deleted WHERE id = '$array[id]' AND email = '$obj[email]'";
        $con = mysqli_query($conn, $del);
        $try = mysqli_fetch_assoc($con);
        if($try){
            $array['deleted'] = 1;
            $data[$i] = $array;

        }else{
            $array['deleted'] = 0;
            $data[$i] = $array;
        }
       $i++;
    }
    if($data){
        echo json_encode($data, true);
    }else{
        echo json_encode('Error');
    }
  }
 }
}else if ($obj['delete_id'] == ""){
    $district = $obj['district'];
    $check = "SELECT * FROM notifications WHERE Sent_To = '$obj[email]' || Sent_To = '$district' || Sent_To = 'all' ORDER BY id DESC";
    $send = mysqli_query($conn, $check);
 if($send){
    $data = array();
    $i = 0;

    while($array = mysqli_fetch_assoc($send)){
        $del = "SELECT * FROM deleted WHERE id = '$array[id]' AND email = '$obj[email]'";
        $con = mysqli_query($conn, $del);
        $try = mysqli_fetch_assoc($con);
        if($try){
            $array['deleted'] = 1;
            $data[$i] = $array;
        }else{
            $array['deleted'] = 0;
            $data[$i] = $array;
        }
       $i++;
    }

    
    if($data){
        echo json_encode($data, true);
    }else{
        echo json_encode('Error');
    }
  }
}
?>