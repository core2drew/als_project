<?php

$is_success= false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $error_fields = [];

  if(empty($_POST['title'])) {
    $error_fields['title'] = 'Title field is required';
  }

  if(count($error_fields) <= 0) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO lessons (title, subject_id, created_at) VALUES ('$title', '$subject_id', '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success= true;
    }
  }
}