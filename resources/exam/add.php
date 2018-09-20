<?php

$is_success= false;
$error_fields = [];
if($_SERVER["REQUEST_METHOD"] == "POST") {

  if(empty($_POST['subject_id'])) {
    $error_fields['subject_id'] = 'Subject field is required';
  }

  if(empty($_POST['title'])) {
    $error_fields['title'] = 'Title field is required';
  }

  if(empty($_POST['instruction'])) {
    $error_fields['instruction'] = 'Instruction field is required';
  }


  if(count($error_fields) <= 0) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO exams (title, subject_id, instruction, created_at) VALUES ('$title', '$subject_id', '$instruction', '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success= true;
    }
  }
}