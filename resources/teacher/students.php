<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $teacher_id = mysqli_real_escape_string($conn, $_GET['teacher_id']);
  $exam_id = mysqli_real_escape_string($conn, $_GET['exam_id']);

  $query = "SELECT users.id, users.firstname FROM users WHERE NOT EXISTS 
  (SELECT user_id FROM users_has_exam WHERE users_has_exam.user_id = users.id AND users_has_exam.exam_id = $exam_id) AND users.teacher_id = $teacher_id AND users.deleted_at iS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  if($result) {
    if($count > 0) {
      $json_data['success'] = true;
    } else {
      $json_data['success'] = false;
      $json_data['message'] = 'You don\'t have student to assign this exam';
    }
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);
