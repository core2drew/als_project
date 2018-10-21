<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
  $exam_id = mysqli_real_escape_string($conn, $_POST['exam_id']);
  $action = isset($_POST['action']) ? $_POST['action'] : null;

  $query = "SELECT id FROM users WHERE teacher_id=$teacher_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);

  $created_at = date("Y-m-d H:i:s");
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $user_id = $row['id'];
    $query = "INSERT INTO users_has_exam (user_id, exam_id, created_at) VALUES ('$user_id', '$exam_id', '$created_at')";
    $result = mysqli_query($conn, $query);
  }

  if($result) {
      $json_data['success'] = true;
      $json_data['message'] = 'Successful exam assigning';
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }
  echo json_encode($json_data);