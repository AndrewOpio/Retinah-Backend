<?php

$dir="chatmedia/";
//Generate image link 
if($_POST['type'] == "image"){
    $image = $_FILES['chatimage'];
    $image_name=$image['name'];
    $image_tmp=$image['tmp_name'];

    move_uploaded_file($image_tmp,$dir.$image_name);
    $uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/chatmedia/";
    $chatimage = $uri.$image_name;

    echo json_encode($chatimage, true);
}

//Generate video link
if($_POST['type'] == "video"){
    $video = $_FILES['chatvideo'];
    $video_name=$video['name'];
    $video_tmp=$video['tmp_name'];

    move_uploaded_file($video_tmp,$dir.$video_name);
    $uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/chatmedia/";
    $chatvideo = $uri.$video_name;

    echo json_encode($chatvideo, true);
}

//Generate audio link
if($_POST['type'] == "audio"){
    $audio = $_FILES['chataudio'];
    $audio_name=$audio['name'];
    $audio_tmp=$audio['tmp_name'];

    move_uploaded_file($audio_tmp,$dir.$audio_name);
    $uri = "https://agencyforadolescents.org/RetinahBackend/RetinahBackend/chatmedia/";
    $chataudio = $uri.$audio_name;

    echo json_encode($chataudio, true);
}

?>













































