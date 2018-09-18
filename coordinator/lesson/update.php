<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/lesson/update.php';

  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=lessons&id=$id&grade_level=$grade_level";
  $back_link = "/coordinator/lesson/lessons.php?page=lessons&grade_level=$grade_level";

  $query = "SELECT
  lessons.title,
  lessons.subject_id,
  lessons.lesson
  FROM lessons WHERE lessons.id = $id";

  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  //Query all Subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";
?>

<div class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="Lessons" class="page">
    <div class="content">
      <?php if(isset($is_success) && $is_success): ?>
        <div class="message">
          <h1>Lessons Updated Successfully</h1>
          <a href=<?php echo $back_link ?>>Back</a>
        </div>
      <?php else: ?>
        <h1 class='title'>Update Lessons</h1>
        <form class="form" method="POST">
          <div class="input">
            <label class="label">Subjects</label>
            <select name="subject_id">
              <?php 
                $subjects_result = mysqli_query($conn, $subjects_query);

                while($subject_row = mysqli_fetch_array($subjects_result, MYSQLI_ASSOC)) {
                  if($row['subject_id'] == $subject_row['id'] ) {
                    echo "<option value='$subject_row[id]' selected>$subject_row[title]</option>";
                  }else {
                    echo "<option value='$subject_row[id]'>$subject_row[title]</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="input">
            <label class="label">Title</label>
            <input type="text" name="title" value="<?php echo $row['title'] ?>"/>
            <?php echo isset($error_fields['title']) ? "<label class='error'>$error_fields[title]</label>" : null ?>
          </div>
          <div id="LessonEditorContainer">
            <div class="document-editor">
              <div class="document-editor__toolbar"></div>
              <div class="document-editor__editable-container">
                  <div class="document-editor__editable">
                    <?php echo $row['lesson'] ?>
                  </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="id" value=<?php echo $id ?> />
          <button class='button submit' type="submit">Update</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
  include '../../includes/html/footer.php';
?>