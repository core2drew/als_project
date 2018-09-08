<?php

$is_success= false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $error_fields = [];

  if(empty($_POST['title'])) {
    $error_fields['title'] = 'Title field is required';
  }

  if(count($error_fields) <= 0) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO subjects (title, grade_level, created_at) VALUES ('$title', '$grade_level', '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success= true;
    }
  }
}