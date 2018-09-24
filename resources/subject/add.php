<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO subjects (title, grade_level, created_at) VALUES ('$title', '$grade_level', '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';;
    }
  }

  echo json_encode($json_data);