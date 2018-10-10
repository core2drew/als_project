<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get current user type
    $user_type = $_POST['user_type'];
    $type = 'quiz';

    //Question data
    $question_type = isset($_POST['question-type']) ? $_POST['question-type'] : null;
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
    $question = isset($_POST['question']) ? $_POST['question'] : null;
    $explanation = isset($_POST['explanation']) ? $_POST['explanation'] : null;
    $is_answer = isset($_POST['is_answer']) ? $_POST['is_answer'] : null;
    $created_at = date("Y-m-d H:i:s");
    $choices = null;

    //Sanitation of question data
    $question_type = mysqli_real_escape_string($conn, $question_type);
    $subject_id = mysqli_real_escape_string($conn, $subject_id);
    $question = mysqli_real_escape_string($conn, $question);
    $explanation = mysqli_real_escape_string($conn, $explanation);
    $is_answer = mysqli_real_escape_string($conn, $is_answer);

    if($question_type === 'multiple') {
      //Choices data
      $choice_1 = isset($_POST['choice_1']) ? $choices['choice_1']['answer'] = $_POST['choice_1'] : null;
      $choice_2 = isset($_POST['choice_2']) ? $choices['choice_2']['answer'] = $_POST['choice_2'] : null;
      $choice_3 = isset($_POST['choice_3']) ? $choices['choice_3']['answer'] = $_POST['choice_3'] : null;
      $choice_4 = isset($_POST['choice_4']) ? $choices['choice_4']['answer'] = $_POST['choice_4'] : null;
      
      //Sanitation of choices data
      $choice_1 = mysqli_real_escape_string($conn, $choice_1);
      $choice_2 = mysqli_real_escape_string($conn, $choice_2);
      $choice_3 = mysqli_real_escape_string($conn, $choice_3);
      $choice_4 = mysqli_real_escape_string($conn, $choice_4);
      
    } elseif ($question_type === 'true-false') {
      $choices['true']['answer'] = 'true';
      $choices['false']['answer'] = 'false';
    } elseif ($question_type === 'fill-in') {
      $fillanswer = isset($_POST['fillanswer']) ? $_POST['fillanswer'] : null;
      $fillanswer = mysqli_real_escape_string($conn, $fillanswer);
    }

    //Insert new question
    $query = "INSERT INTO questions (question, subject_id, explanation, type, question_type, created_at) VALUES ('$question', $subject_id, '$explanation', '$type', '$question_type','$created_at')";
    $question_result = mysqli_query($conn, $query);
    
    if($question_result) {
      $last_id = mysqli_insert_id($conn);
      $choices[$is_answer]['is_answer'] = 1;

      if($question_type === 'multiple') {
        foreach($choices as $choice) {
          $is_answer = isset($choice['is_answer']) ? $choice['is_answer'] : 0;
          $answer = $choice['answer'];
          $answer_query = "INSERT INTO answers (question_id, answer, is_answer, created_at) VALUES ($last_id, '$answer', $is_answer, '$created_at')";
          $answer_result = mysqli_query($conn, $answer_query);
        }
      } elseif($question_type === 'true-false') {

        foreach($choices as $choice) {
          $is_answer = isset($choice['is_answer']) ? $choice['is_answer'] : 0;
          $answer = $choice['answer'];
          $answer_query = "INSERT INTO answers (question_id, answer, is_answer, created_at) VALUES ($last_id, '$answer', $is_answer, '$created_at')";
          $answer_result = mysqli_query($conn, $answer_query);
        }
      } elseif ($question_type === 'fill-in') {
        $is_answer = 1; //Always true
        $answer_query = "INSERT INTO answers (question_id, answer, is_answer, created_at) VALUES ($last_id, '$fillanswer', $is_answer, '$created_at')";
        $answer_result = mysqli_query($conn, $answer_query);
      }
      
      //Insert new question to current quiz
      if(isset($_POST['quiz_id'])) {
        $quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
        $exam_query = "SELECT questions_id FROM quizzes WHERE id=$quiz_id";
        $exam_result = mysqli_query($conn, $exam_query);
        $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
        $questions_id_array = !empty($exam_row['questions_id']) ? explode(',', $exam_row['questions_id']) : [];

        array_push($questions_id_array, $last_id);
        if(count($questions_id_array)) {
          $exam_query = "UPDATE quizzes SET questions_id='". implode(",", $questions_id_array) ."' WHERE id=$quiz_id";
        } else {
          $exam_query = "UPDATE quizzes SET questions_id=NULL WHERE id=$quiz_id";
        }
        $exam_result = mysqli_query($conn, $exam_query);
        if($exam_result) {
          $json_data['success'] = true;
        } else {
          $json_data['message'] = 'Oops, something went wrong.';
        }
      }
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);