<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  //Query all Subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=lessonandvideos&sub_page=lessons&grade_level=$grade_level";
  $back_link = "/coordinator/lesson/lessons.php?page=lessonandvideos&sub_page=lessons&grade_level=$grade_level";
?>

<div class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="Lessons" class="page">
    <div class="content">
      <?php if(isset($is_success) && $is_success): ?>
        <div class="message">
          <h1>Lesson Created Successfully</h1>
          <a href=<?php echo $back_link ?> >Back</a>
        </div>
      <?php else: ?>
        <h1 class='title'>Create Lesson</h1>
        <form class="form" method="POST">
          <div class="input">
            <label class="label">Subjects</label>
            <select name="subject_id">
              <?php 
                $subjects_result = mysqli_query($conn, $subjects_query);
                $subjects_count = mysqli_num_rows($subjects_result);

                while($subject_row = mysqli_fetch_array($subjects_result, MYSQLI_ASSOC)) {
                  echo "<option value='$subject_row[id]'>$subject_row[title]</option>";
                }
              ?>
            </select>
          </div>
          <div class="input">
            <label class="label">Title</label>
            <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
            <?php echo isset($error_fields['title']) ? "<label class='error'>$error_fields[title]</label>" : null ?>
          </div>
          <div id="LessonEditorContainer">
            <div class="document-editor">
              <div class="document-editor__toolbar"></div>
              <div class="document-editor__editable-container">
                  <div class="document-editor__editable"></div>
              </div>
            </div>
          </div>
          <button class='button submit' type="submit">Create</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include '../../includes/html/scripts.php';?>
<script src="/public/ckeditor5/ckeditor.js"></script>
<script src="/public/js/modules/lesson.js"></script>
<?php include '../../includes/html/footer.php'; ?>