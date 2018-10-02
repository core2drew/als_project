<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null; 
  
  $quiz_query= "SELECT 
  title, questions_id, minutes, instruction
  FROM quizzes 
  WHERE id=$quiz_id AND deleted_at IS NULL";
  $quiz_result = mysqli_query($conn, $quiz_query);
  $quiz_row = mysqli_fetch_array($quiz_result, MYSQLI_ASSOC);

  if($quiz_result) {
    $json_data['success'] = true;
    $json_data['data'] = $quiz_row;
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);