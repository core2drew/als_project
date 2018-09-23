<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = isset($_POST['lesson_id']) ? $_POST['lesson_id'] : null;
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $editor_data = isset($_POST['editor_data']) ? $_POST['editor_data'] : null;

    $id = mysqli_real_escape_string($conn, $id);
    $subject_id = mysqli_real_escape_string($conn, $subject_id);
    $title = mysqli_real_escape_string($conn, $title);
    $editor_data = mysqli_real_escape_string($conn, $editor_data);

    $query = "UPDATE lessons SET title='$title', subject_id=$subject_id, lesson='$editor_data' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);