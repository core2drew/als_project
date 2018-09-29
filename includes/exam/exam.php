<?php 
    $exam_query= "SELECT title, questions_id, minutes, instruction FROM exams WHERE id=$exam_id AND deleted_at IS NULL";
    $exam_result = mysqli_query($conn, $exam_query);
    $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
    
    $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null; 
    $questions_id = isset($exam_row['questions_id']) ? $exam_row['questions_id'] : null; 
    
    $minutes = isset($exam_row['minutes']) ? $exam_row['minutes'] : null; 

    // convert string to array example "1,2,3" to [1,2,3]
    $questions_id = explode(',', $questions_id);
    $items_count = count($questions_id);

    // format array to string 1','2','3','4
    $questions_id = implode(",", $questions_id);

    $go_back_link = $is_coordinator || $is_teacher ? "$_SERVER[PHP_SELF]?subject_id=$subject_id" : null;
    
    $query = "SELECT * FROM users_has_exam WHERE user_id=$_SESSION[user_id] AND exam_id=$exam_id AND deleted_at IS NULL AND taken_at IS NOT NULL";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if($count <= 0) {
      //Update take exam
      if($is_student) {
        $taken_at = date("Y-m-d H:i:s");
        $take_exam_query= "UPDATE users_has_exam SET taken_at = '$taken_at' WHERE user_id=$_SESSION[user_id] AND exam_id=$exam_id AND deleted_at IS NULL";
        $take_exam_result = mysqli_query($conn, $take_exam_query);
      }
    }
?>

<?php if($is_coordinator || $is_teacher): ?>
  <div class="title">
      <a class="button" href="<?php echo $go_back_link ?>">Back</a>
  </div>
<?php endif ?>

<?php if($is_student && $count <= 0): ?>
  <div id="CountDown" data-exam-minutes="<?php echo $minutes ?>">
    <h3 class="minutes"><?php echo '00:'.$minutes.':00' ?></h3>
  </div>
  <div id="ExamQuestions" data-exam-id="<?php echo $exam_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $_SESSION['user_id'] ?>></div>
  <div id="SubmitExam" class="button">Submit</div>
<?php else: ?>
  <div id="ExamQuestionsAnswers" data-exam-id="<?php echo $exam_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $_SESSION['user_id'] ?>></div>
<?php endif ?>

<?php if($is_teacher || $is_coordinator): ?>
  <div id="ExamQuestions" data-exam-id="<?php echo $exam_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $_SESSION['user_id'] ?>></div>
<?php endif ?>