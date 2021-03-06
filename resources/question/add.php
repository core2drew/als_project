<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    //Question data
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
    $question = isset($_POST['question']) ? $_POST['question'] : null;
    $explanation = isset($_POST['explanation']) ? $_POST['explanation'] : null;

    //Choices data
    $choice_1 = isset($_POST['choice_1']) ? $choices['choice_1']['answer'] = $_POST['choice_1'] : null;
    $choice_2 = isset($_POST['choice_2']) ? $choices['choice_2']['answer'] = $_POST['choice_2'] : null;
    $choice_3 = isset($_POST['choice_3']) ? $choices['choice_3']['answer'] = $_POST['choice_3'] : null;
    $choice_4 = isset($_POST['choice_4']) ? $choices['choice_4']['answer'] = $_POST['choice_4'] : null;
    $is_answer = isset($_POST['is_answer']) ? $_POST['is_answer'] : null;

    //Sanitation of question data
    $subject_id = mysqli_real_escape_string($conn, $subject_id);
    $question = mysqli_real_escape_string($conn, $question);
    $explanation = mysqli_real_escape_string($conn, $explanation);

    //Sanitation of choices data
    $choice_1 = mysqli_real_escape_string($conn, $choice_1);
    $choice_2 = mysqli_real_escape_string($conn, $choice_2);
    $choice_3 = mysqli_real_escape_string($conn, $choice_3);
    $choice_4 = mysqli_real_escape_string($conn, $choice_4);
    $is_answer = mysqli_real_escape_string($conn, $is_answer);
   
    //Get current user type
    $user_type = $_POST['user_type'];
    $type = null;
    
    if($user_type === 'coordinator') {
      $type = 'exam';
    }else if($user_type === 'teacher') {
      $type = 'quiz';
    }
  
    $choices[$is_answer]['is_answer'] = 1;
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO questions (question, subject_id, explanation, type, created_at) VALUES ('$question', $subject_id, '$explanation', '$type', '$created_at')";
    $question_result = mysqli_query($conn, $query);
    if($question_result) {
      $last_id = mysqli_insert_id($conn);
      foreach($choices as $choice) {
        $answer = $choice['answer'];
        $is_answer = isset($choice['is_answer']) ? $choice['is_answer'] : 0;
        $created_at = date("Y-m-d H:i:s");
        $query = "INSERT INTO answers (question_id, answer, is_answer, created_at) VALUES ($last_id, '$answer', $is_answer, '$created_at')";
        $answer_result = mysqli_query($conn, $query);
      }
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);