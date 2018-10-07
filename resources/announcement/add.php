<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $announcement = mysqli_real_escape_string($conn, $_POST['announcement']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO announcements (title, user_id, announcement, created_at) VALUES 
    ('$title', '$user_id', '$announcement', '$created_at')";
    $result = mysqli_query($conn, $query);
    
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);