<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $user_id = mysqli_real_escape_string($conn, $_POST['student_id']);
  $quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
  $action = isset($_POST['action']) ? $_POST['action'] : null;

  if($action === 'remove') {
    $deleted_at = date("Y-m-d H:i:s");
    $query = "UPDATE users_has_quiz SET deleted_at = '$deleted_at' WHERE user_id=$user_id AND deleted_at IS NULL";
    $result = mysqli_query($conn, $query);

    if($result) {
        $json_data['success'] = true;
        $json_data['message'] = 'Quiz has been unassign';
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }

  } else {
    //Get Questions id
    $query = "SELECT questions_id FROM quizzes WHERE id=$quiz_id AND deleted_at IS NULL";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $created_at = date("Y-m-d H:i:s");
    $query = "INSERT INTO users_has_quiz (user_id, quiz_id, created_at) VALUES ('$user_id', '$quiz_id', '$created_at')";
    $result = mysqli_query($conn, $query);

    if($result) {
        $json_data['success'] = true;
        $json_data['message'] = 'Successful quiz assigning';
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }
  echo json_encode($json_data);