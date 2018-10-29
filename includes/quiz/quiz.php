<?php 
    $exam_query= "SELECT minutes FROM quizzes WHERE id=$quiz_id AND deleted_at IS NULL";
    $exam_result = mysqli_query($conn, $exam_query);
    $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);

    $questions_query = "SELECT questions_id FROM users_has_quiz WHERE quiz_id = $quiz_id AND user_id = $_SESSION[user_id]";
    $questions_result = mysqli_query($conn, $questions_query);
    $questions_row = mysqli_fetch_array($questions_result, MYSQLI_ASSOC);
    
    $questions_id = isset($questions_row['questions_id']) ? $questions_row['questions_id'] : null; 
    
    $minutes = isset($exam_row['minutes']) ? $exam_row['minutes'] : null; 

    // convert string to array example "1,2,3" to [1,2,3]
    $questions_id = explode(',', $questions_id);
    $items_count = count($questions_id);

    // format array to string 1','2','3','4
    $questions_id = implode(",", $questions_id);
    
    $query = "SELECT * FROM users_has_quiz WHERE user_id=$user_id AND quiz_id=$quiz_id AND deleted_at IS NULL AND taken_at IS NOT NULL";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if($count <= 0) {
      //Update take exam
      if($user_type == 'student') {
        $taken_at = date("Y-m-d H:i:s");
        $take_exam_query= "UPDATE users_has_quiz SET taken_at = '$taken_at' WHERE user_id=$user_id AND quiz_id=$quiz_id AND deleted_at IS NULL";
        $take_exam_result = mysqli_query($conn, $take_exam_query);
      }
    }
?>

<?php if($user_type == 'teacher'): ?>
  <div class="title">
      <a class="button" href="<?php echo "$_SERVER[PHP_SELF]?subject_id=$subject_id" ?>">Back</a>
  </div>
<?php endif ?>

<?php if($user_type == 'student' && $count <= 0): ?>
  <div id="CountDown" data-quiz-minutes="<?php echo $minutes ?>">
    <h3 class="minutes"><?php echo '00:'.$minutes.':00' ?></h3>
  </div>
  <div id="QuizQuestions" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
  <div id="SubmitQuiz" class="button">Submit</div>
<?php else: 
    //Get exam result
    $exam_result_query = "SELECT
    (
      SELECT COUNT(*) FROM quiz_records as qr
      LEFT JOIN answers as ans
      ON qr.answer_id = ans.id
      WHERE qr.user_id = uq.user_id AND ans.is_answer = 1 AND qr.exam_id = $quiz_id
    ) as score,
    ( SELECT questions_id FROM users_has_quiz WHERE quiz_id = $quiz_id AND user_id = $user_id) as items 
    FROM users student RIGHT JOIN users_has_quiz as uq
    ON student.id = uq.user_id
    WHERE student.id = $_SESSION[user_id] AND uq.quiz_id = $quiz_id AND student.deleted_at IS NULL AND uq.taken_at IS NOT NULL";
    $exam_query_result = mysqli_query($conn, $exam_result_query);
    $exam_result_row = mysqli_fetch_array($exam_query_result, MYSQLI_ASSOC);

    $items = count(explode(',', $exam_result_row['items']));
    $score = $exam_result_row['score'].'/'.$items;
    $percentage = ($exam_result_row['score'] / $items) * 100;
    $percentage = number_format($percentage, 2);
?>
  <div id="QuizResultsContainer">
    <div id="QuizQuestionsAnswers" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
    <div id="QuizResult">
      <h3 class="title">Legend:</h3>
      <div class="legend correct">
        <span class="legend"></span>
        Correct Answer
      </div>
      <div class="legend wrong">
        <span class="legend"></span>
        Wrong Answer
      </div>
      <div class="score">
        <h3 class="title">Score: <?php echo $score ?></h3>
      </div>
      <div class="percentage">
        <h3 class="title">Percentage: <?php echo $percentage ?></h3>
      </div>
    </div>
  </div>
<?php endif ?>

<?php if($user_type == 'teacher'): ?>
  <div id="QuizQuestions" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
<?php endif ?>