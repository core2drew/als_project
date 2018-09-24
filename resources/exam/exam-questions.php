<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  //Get Id of exam
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null; 
  $questions_id = isset($_GET['questions_id']) ? $_GET['questions_id'] : null; 

  // //Get question ids of exam
  // $exam_query = "SELECT questions_id FROM exams WHERE id=$exam_id";
  // $exam_result = mysqli_query($conn, $exam_query);
  // $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);

  // convert string to array example "1,2,3" to [1,2,3]
  $questions_id = explode(',', $questions_id);

  // format array to string 1','2','3','4
  $questions_id = implode("','", $questions_id);

  //Get current questions of exam
  $question_query = "SELECT DISTINCT quest.id, quest.question, ex.minutes FROM exams ex 
  LEFT JOIN questions quest ON ex.subject_id = quest.subject_id WHERE quest.id IN ('". $questions_id ."') AND quest.deleted_at IS NULL";
  //Results of query
  $question_result = mysqli_query($conn, $question_query);

  if($question_result) {
    $json_data['success'] = true;
    $json_data['data'] = [];

    while($question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
      $data['question'] = $question_row['question'];
      $data['answers'] = [];

      $answer_query = "SELECT id, answer, is_answer FROM answers WHERE question_id = $question_row[id]";
      $answer_result = mysqli_query($conn, $answer_query);

      while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
        $answer_data = [
          'id' => $answer_row['answer'],
          'answer' => $answer_row['answer'],
          'is_answer' => (int)$answer_row['is_answer'] === 1 ? true : false
        ];
        array_push($data['answers'], $answer_data);
      }
      array_push($json_data['data'], $data);
    }
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);