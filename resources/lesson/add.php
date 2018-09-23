<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');
  
  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $editor_data = isset($_POST['editor_data']) ? $_POST['editor_data'] : null;

    $subject_id = mysqli_real_escape_string($conn, $subject_id);
    $title = mysqli_real_escape_string($conn, $title);
    $editor_data = mysqli_real_escape_string($conn, $editor_data);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO lessons (title, subject_id, created_at, lesson) VALUES ('$title', '$subject_id', '$created_at', '$editor_data')";
    $result = mysqli_query($conn, $query);

    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);