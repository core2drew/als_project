<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $slider_image_url = "";
    
    $tmp_name = $_FILES["activity_image"]["tmp_name"];
    if(!empty($tmp_name)) {
      $ext = findexts($_FILES['activity_image']['name']); 
      $filename = time().".".$ext;
      move_uploaded_file($tmp_name, "../../public/images/sliders/" . $filename);
      $slider_image_url = "/public/images/sliders/" . $filename;
    } else {
      $slider_image_url = '/public/images/slider-placeholder-image.jpg';
    }

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO activities (title, image_url, description, created_at) VALUES 
    ('$title', '$slider_image_url', '$description', '$created_at')";
    $result = mysqli_query($conn, $query);
    
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);