<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $teacher_id = mysqli_real_escape_string($conn, $_GET['teacher_id']);
  $exam_id = mysqli_real_escape_string($conn, $_GET['exam_id']);

  $query ="SELECT users.id, CONCAT(users.lastname, ', ' ,users.firstname) as name,
  (SELECT DISTINCT (id IS NOT NULL) FROM users_has_exam WHERE exam_id = $exam_id AND users.id = users_has_exam.user_id ORDER BY users_has_exam.id DESC LIMIT 1) as has_exam,
  (SELECT DISTINCT (taken_at IS NOT NULL) FROM users_has_exam WHERE exam_id = $exam_id AND users.id = users_has_exam.user_id AND users_has_exam.deleted_at IS NULL ORDER BY users_has_exam.id DESC LIMIT 1) as is_taken
  FROM users WHERE users.teacher_id = $teacher_id";
  
  $result = mysqli_query($conn, $query);

  if($result) {
    $json_data['success'] = true;
    $json_data['data'] = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $json_data['data'][] = $row;
    }
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);