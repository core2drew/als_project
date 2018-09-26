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
?>

<div class="title">
  <h2><?php echo $exam_row['title'] ?></h2>
  <?php if($is_coordinator || $is_teacher): ?>
    <a class="button" href="<?php echo $go_back_link ?>">Back</a>
  <?php endif ?>
</div>
<!-- <div class="exam-items exam-detail">
  <label>Items:</label>  
  <?php echo $items_count ?>
</div> -->
<div id="CountDown" data-exam-minutes="<?php echo $minutes ?>">
  <h3 class="minutes"><?php echo '00:'.$minutes.':00' ?></h3>
</div>
<div class="exam-instruction exam-detail">
  <label>Instruction:</label>  
  <?php echo $exam_row['instruction'] ?>
</div>

<div id="ExamQuestions" data-exam-id="<?php echo $exam_id ?>" data-questions-id="<?php echo $questions_id ?>" data-minutes=<?php echo $minutes ?>></div>