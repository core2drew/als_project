<?php
require '../../config/db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');
  $error_fields = [];

  if(empty($_POST['question'])) {
    array_push($error_fields, 'Question field is required');
  }

  if(empty($_POST['choice_1'])) {
    array_push($error_fields, 'Choice 1 field is required');
  }

  if(empty($_POST['choice_2'])) {
    array_push($error_fields, 'Choice 2 field is required');
  }

  if(empty($_POST['choice_3'])) {
    array_push($error_fields, 'Choice 3 field is required');
  }

  if(empty($_POST['choice_4'])) {
    array_push($error_fields, 'Choice 4 field is required');
  }

  if(empty($_POST['is_answer'])) {
    array_push($error_fields, 'Select question answer');
  }

  if(count($error_fields) > 0) {
    $json = ['success' => false, 'data' => $error_fields];
    echo json_encode($json);
    die();
  }

  $question = mysqli_real_escape_string($conn, $_POST['question']);
  $choice_1 = mysqli_real_escape_string($conn, $_POST['choice_1']);
  $choice_2 = mysqli_real_escape_string($conn, $_POST['choice_2']);
  $choice_3 = mysqli_real_escape_string($conn, $_POST['choice_3']);
  $choice_4 = mysqli_real_escape_string($conn, $_POST['choice_4']);
  $answer = mysqli_real_escape_string($conn, $_POST['is_answer']);

  $choices = [
    'choice_1' => [
      'answer' => $choice_1,
      'is_answer' => 0
    ],
    'choice_2' => [
      'answer' => $choice_2,
      'is_answer' => 0
    ],
    'choice_3' => [
      'answer' => $choice_3,
      'is_answer' => 0
    ],
    'choice_4' => [
      'answer' => $choice_4,
      'is_answer' => 0
    ]
  ];
  $choices[$answer]['is_answer'] = 1;

  $query = "INSERT INTO questions (question) VALUES ('$question')";
  $question_result = mysqli_query($conn, $query);
  

  if($question_result) {
    $last_id = mysqli_insert_id($conn);
    foreach($choices as $choice) {
      $answer = $choice['answer'];
      $is_answer = $choice['is_answer'];
      $query = "INSERT INTO answers (question_id, answer, is_answer) VALUES ('$last_id', '$answer', '$is_answer')";
      $answer_result = mysqli_query($conn, $query);
    }

    mysqli_close($conn);

    $json = ['success' => true, 'answer' => $choices];
    echo json_encode($json);
  } else {
    //echo "Error " . mysqli_error($conn);
    $json = ['success' => false, 'message' => 'Something went wrong'];
  }
}

