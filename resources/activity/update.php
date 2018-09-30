<?php 
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $tmp_name = $_FILES["activity_image"]["tmp_name"];
    $slider_image_url = "";

    if(!empty($tmp_name)) {
      $ext = findexts($_FILES['activity_image']['name']); 
      $filename = time().".".$ext;
      move_uploaded_file($tmp_name, "../../public/images/sliders/" . $filename);
      $slider_image_url = "/public/images/sliders/" . $filename;
    } else {
      $slider_image_url = mysqli_real_escape_string($conn, $_POST['slider_image_url']);
    }

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $slider_image_url = mysqli_real_escape_string($conn, $slider_image_url);

    $query = "UPDATE activities SET title='$title', description='$description', image_url='$slider_image_url' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);