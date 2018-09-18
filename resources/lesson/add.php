<?php
  require '../../config/db_connect.php';

$is_success= false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $error_fields = [];

  if(empty($_POST['subject_id'])) {
    $error_fields['subject_id'] = 'Subject field is required';
  }

  if(empty($_POST['title'])) {
    $error_fields['title'] = 'Title field is required';
  }

  if(count($error_fields) <= 0) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $editor_data = mysqli_real_escape_string($conn, $_POST['editor_data']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO lessons (title, subject_id, created_at, lesson) VALUES ('$title', '$subject_id', '$created_at', '$editor_data')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success= true;
    }
  }
}