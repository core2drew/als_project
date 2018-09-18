<?php
  require '../../config/db_connect.php';

  $is_success = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_fields = [];

    if(empty($_POST['title'])) {
      $error_fields['title'] = 'Title field is required';
    }

    if(count($error_fields) <= 0) {
      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $editor_data = mysqli_real_escape_string($conn, $_POST['editor_data']);
      $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);

      $query = "UPDATE lessons SET title='$title', subject_id=$subject_id, lesson='$editor_data' WHERE id=$id";
      $result = mysqli_query($conn, $query);
      echo $query;
      if($result) {
        $json_data['success'] = true;
      }
    }
  }