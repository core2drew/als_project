<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');
  $json_data['success'] = false;

  $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;

  $questions_id = isset($_GET['questions_id']) ? mysqli_real_escape_string($conn, $_GET['questions_id']) : null; 
  // convert string to array example "1,2,3" to [1,2,3]
  $questions_id = explode(',', $questions_id);
  // format array to string 1','2','3','4
  $questions_id = implode("','", $questions_id);

  //Get current questions of exam
  $question_query = "SELECT DISTINCT quest.id, quest.question, quest.explanation FROM exams ex 
  LEFT JOIN questions quest ON ex.subject_id = quest.subject_id
  WHERE quest.id IN ('". $questions_id ."') AND quest.deleted_at IS NULL";

  //Results of query
  $question_result = mysqli_query($conn, $question_query);

  if($question_result) {
    $json_data['success'] = true;
    $json_data['data'] = [];

    while($question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
      $data = [];
      $data['id'] = $question_row['id'];
      $data['question'] = $question_row['question'];
      
      if(isset($question_row['explanation']) && !empty($question_row['explanation'])) {
        $data['explanation'] = $question_row['explanation'];
      }
      $data['answers'] = [];
      $answer_query = "SELECT ans.id, ans.answer, ans.is_answer, er.user_id FROM answers as ans LEFT JOIN exam_records as er  ON er.answer_id = ans.id AND er.user_id = $user_id WHERE ans.question_id = $question_row[id] AND er.exam_id = $exam_id ORDER BY id ASC";
      $answer_result = mysqli_query($conn, $answer_query);

      while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
        $answer_data = [
          'id' => $answer_row['id'],
          'answer' => $answer_row['answer'],
          'user_answer' => isset($answer_row['user_id']) ? true : false,
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