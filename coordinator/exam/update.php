<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/exam/update.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $exam_id = isset($_GET['id']) ? $_GET['id'] : null;

  $exam_query = "SELECT questions_id FROM exams WHERE id=$exam_id";
  $exam_result = mysqli_query($conn, $exam_query);
  $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
  $questions_id = explode(',', $exam_row['questions_id']);

  $question_query = "SELECT DISTINCT quest.id, quest.question,
  (SELECT answer FROM answers WHERE question_id = quest.id AND is_answer = 1 LIMIT 0,1) as answer
  FROM exams ex LEFT JOIN questions quest ON ex.subject_id = quest.subject_id 
  WHERE quest.id IN ('". implode("','",$questions_id) ."') AND quest.deleted_at IS NULL";
  $question_result = mysqli_query($conn, $question_query);


  $query = "SELECT id, title, subject_id, if( questions_id IS NULL,'', questions_id) as questions_id
  FROM exams WHERE id=$exam_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  $title = $row['title'];
  $subject_id = $row['subject_id'];
  $questions_id = [];

  if(!empty($row['questions_id'])) {
    $questions_id = explode(", ", $row['questions_id']);
  }
  
  $question_count = count($questions_id);

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=exams&grade_level=$grade_level";
  $back_link = "/coordinator/question/questions.php?page=questions&grade_level=$grade_level";

  function handleErrorMessage($field, $error_fields = null){
    if(isset($error_fields)) {
      echo isset($error_fields[$field]) ? "<label class='error'>$error_fields[$field]</label>" : null;
    }
  }
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageExams" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Exam Updated Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Update <?php echo $title ?> Question</h1>
      <div class="table-actions">
        <button class='button' id="AddExamQuestionBtn">Add Question</button>
      </div>
      <?php
        if($question_count <= 0):
      ?>
        <table class="table exam-questions">
          <thead>
            <th>Question</th>
            <th>Answer</th>
            <th>Option</th>
          </thead>
        </table>
        <div class="no-records">
          <h3>No Records</h3>
        </div>
      <?php else: ?>
        <table class="table exam-questions">
          <thead>
            <th>Question</th>
            <th>Answer</th>
            <th>Option</th>
          </thead>
          <tbody>
            <?php
              while($qr = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
                $id = $qr['id'];
                $question = $qr['question'];
                $answer = $qr['answer'];
                $view = "<button class='button view'>View</button>";
                $remove = "<button class='button remove-question' data-question-id=$id>Remove</button>";
                $table_row =
                "<tr>
                  <td>$question</td>
                  <td>$answer</td>
                  <td>$view $remove</td>
                </tr>";
                echo $table_row;
              }
            ?>
          </tbody>
        </table>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<div class="modal-container">
  <div id="AddExamQuestionModal" class="modal" data-subject-id="<?php echo $subject_id ?>" data-exam-id="<?php echo $exam_id ?>">
    <svg version="1.1" class="icon close"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 371.23 371.23" style="enable-background:new 0 0 371.23 371.23;" xml:space="preserve">
    <polygon points="371.23,21.213 350.018,0 185.615,164.402 21.213,0 0,21.213 164.402,185.615 0,350.018 21.213,371.23 
      185.615,206.828 350.018,371.23 371.23,350.018 206.828,185.615 "/>
    </svg>
    <div class="loading">
      <div class="lds-ripple">
        <div class="ripple"></div>
        <div class="ripple"></div>
      </div>
    </div>
    <h2 class="title">Add Questions</h2>
    <table class="table">
      <thead class="header">
        <th>Question</th>
        <th>Include</th>
      </thead>
      <!-- <div class="body">
        <div class="row">
          <span class="td">What is science?</span>
          <span class="td">View</span>
        </div>
      </div> -->
    </table>
    <div class="no-records">
      <h3>No Records</h3>
    </div>

    <button class='button save-question'>Save</button>
  </div>
</div>
<?php include '../../includes/html/scripts.php';?>
<script src="/public/js/modules/exam.js"></script>
<?php include '../../includes/html/footer.php'; ?>