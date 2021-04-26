<?php
include 'connect.php';

$json = file_get_contents('php://input');
$obj  = json_decode($json, true);

$title = $_POST['title'];
$description = $_POST['description'];
$link = $_POST['link'];
$type = $_POST['type'];
$time = date("h:i:sa");
$date = date("Y/m/d"); 
$user = $_POST['user'];
$email = $_POST['email'];
$category = $_POST['category'];
$approved = $_POST['approved'];

if($type == "image"){
    $dir="media/";
    $image = $_FILES['image'];
    $image_name=$image['name'];
    $image_tmp=$image['tmp_name'];

    move_uploaded_file($image_tmp,$dir.$image_name);
    $uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/media/";
    $media = $uri.$image_name;
}else if($type == "video"){
    $dir="media/";
    $video = $_FILES['video'];
    $video_name=$video['name'];
    $video_tmp=$video['tmp_name'];

    move_uploaded_file($video_tmp,$dir.$video_name);
    $uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/media/";
    $media = $uri.$video_name;
}

//Inserting into home
    $query = "INSERT INTO home (title, date, time, description, type, link, media, posted_by, email, category, approved) VALUES ('$title','$date', '$time','$description','$type', '$link','$media', '$user', '$email', '$category', '$approved')";
    $insert = mysqli_query($conn, $query);
    if(!$insert){
        echo json_encode(mysqli_error($conn));
    }else{
        echo json_encode("Inserted");
    }
?>       
























































































