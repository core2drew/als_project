<?php
    require '../../config/db_connect.php';
    include '../../includes/html/head.php';
    include '../../check_session.php';
    include '../../includes/header.php';
    include '../../resources/exam/delete.php';

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
    $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=examandquestions&sub_page=exams&grade_level=$grade_level&id=$id";
    $back_link = "/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&grade_level=$grade_level";

    $query = "SELECT id FROM questions WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageExam" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Question Deleted Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Delete Exam</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <input type="hidden" name="id" value=<?php echo $row['id'] ?> />
        <p>Are you sure you want to delete this exam?</p>
        <button class='button confirm-delete' type="submit">Yes</button>
        <a class='button cancel-delete' href="<?php echo $back_link ?>">No</a>
      </form>
    <?php endif; ?>
  </div>
</div>


<?php
  include '../../includes/html/footer.php';
?>