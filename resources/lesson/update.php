<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    //Reviewer File
    $file_name = !empty($_FILES['reviewer_file']['name']) ? $_FILES['reviewer_file']['name'] : null;

    $id = isset($_POST['lesson_id']) ? $_POST['lesson_id'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $editor_data = isset($_POST['editor_data']) ? $_POST['editor_data'] : null;

    $id = mysqli_real_escape_string($conn, $id);
    $title = mysqli_real_escape_string($conn, $title);
    $editor_data = mysqli_real_escape_string($conn, $editor_data);
    $file_name = mysqli_real_escape_string($conn, $file_name);

    if(isset($file_name) && !empty($file_name)) {

      $file_size = $_FILES['reviewer_file']['size'];
      $tmp_name = $_FILES['reviewer_file']['tmp_name'];
      $ext = findexts($file_name); 
      $filename = time().".".$ext;
      move_uploaded_file($tmp_name, "../../public/reviewers/" . $filename);
      $reviewer_link = "/public/reviewers/" . $filename;

      $query = "UPDATE lessons SET
        title = '$title', lesson = '$editor_data', reviewer_link = '$reviewer_link', reviewer_filename = '$file_name' WHERE id=$id";
    } else {
      $query = "UPDATE lessons SET title='$title', lesson='$editor_data' WHERE id=$id";
    }
    $result = mysqli_query($conn, $query);

    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);