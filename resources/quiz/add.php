<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');
  
  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $minutes = mysqli_real_escape_string($conn, $_POST['minutes']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO quizzes (user_id, title, subject_id, instruction, minutes, created_at) VALUES ('$user_id', '$title', '$subject_id', '$instruction', $minutes, '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);