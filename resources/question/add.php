<?php

$is_success= false;
$error_fields = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {

  if(empty($_POST['subject_id'])) {
    $error_fields['subject_id'] = 'Subject field is required';
  }

  if(empty($_POST['question'])) {
    $error_fields['question'] = 'Question field is required';
  }

  if(empty($_POST['choice_1']) && !is_numeric($_POST['choice_1'])) {
    $error_fields['choice_1'] = 'Choice 1 field is required';
  }

  if(empty($_POST['choice_2']) && !is_numeric($_POST['choice_2'])) {
    $error_fields['choice_2'] = 'Choice 2 field is required';
  }

  if(empty($_POST['choice_3']) && !is_numeric($_POST['choice_3'])) {
    $error_fields['choice_3'] = 'Choice 3 field is required';
  }

  if(empty($_POST['choice_4']) && !is_numeric($_POST['choice_4'])) {
    $error_fields['choice_4'] = 'Choice 4 field is required';
  }

  if(count($error_fields) <= 0) {
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $choice_1 = mysqli_real_escape_string($conn, $_POST['choice_1']);
    $choice_2 = mysqli_real_escape_string($conn, $_POST['choice_2']);
    $choice_3 = mysqli_real_escape_string($conn, $_POST['choice_3']);
    $choice_4 = mysqli_real_escape_string($conn, $_POST['choice_4']);
    $explanation = mysqli_real_escape_string($conn, $_POST['explanation']);
    $answer = mysqli_real_escape_string($conn, $_POST['is_answer']);
    $user_type = $_SESSION['type'];
    $type = null;

    if($user_type === 'coordinator') {
      $type = 'exam';
    }else if($user_type === 'teacher') {
      $type = 'quiz';
    }

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
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO questions (question, subject_id, explanation, type, created_at) VALUES ('$question', $subject_id, '$explanation', '$type', '$created_at')";
    $question_result = mysqli_query($conn, $query);
    if($question_result) {
      $last_id = mysqli_insert_id($conn);
      foreach($choices as $choice) {
        $answer = $choice['answer'];
        $is_answer = $choice['is_answer'];
        $query = "INSERT INTO answers (question_id, answer, is_answer) VALUES ($last_id, '$answer', $is_answer)";
        $answer_result = mysqli_query($conn, $query);
      }
      $is_success= true;
      mysqli_close($conn);
    }
  }
}

