<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $student_assign_count = 0;
  $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
  $quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
  $action = isset($_POST['action']) ? $_POST['action'] : null;

  $student_query = "SELECT users.id, users_has_quiz.quiz_id
  FROM users LEFT JOIN users_has_quiz ON users.id = users_has_quiz.user_id AND users_has_quiz.quiz_id=$quiz_id AND users_has_quiz.deleted_at IS NULL
  WHERE users.teacher_id=$teacher_id
  AND users.deleted_at IS NULL";

  $student_result = mysqli_query($conn, $student_query);

  //Get Questions id
  $question_query = "SELECT questions_id FROM quizzes WHERE id=$quiz_id AND deleted_at IS NULL";
  $question_result = mysqli_query($conn, $question_query);
  $question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC);

  $created_at = date("Y-m-d H:i:s");
  while($row = mysqli_fetch_array($student_result, MYSQLI_ASSOC)) {
    if(!isset($row['quiz_id'])) {
      $student_assign_count++;
      $user_id = $row['id'];
      $query = "INSERT INTO users_has_quiz (user_id, quiz_id, created_at, questions_id) VALUES ('$user_id', '$quiz_id', '$created_at', '$question_row[questions_id]')";
      $result = mysqli_query($conn, $query);
    }
  }

  if($student_assign_count) {
    if($result) {
        $json_data['success'] = true;
        $json_data['message'] = 'Successful quiz assigning to all of your student';
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  } else {
    $json_data['message'] = 'This quiz is already assigned to all of your student';
  }
  echo json_encode($json_data);