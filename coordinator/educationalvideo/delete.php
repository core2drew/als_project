<?php
    require '../../config/db_connect.php';
    include '../../includes/html/head.php';
    include '../../check_session.php';
    include '../../includes/header.php';
    include '../../resources/educationalvideo/delete.php';

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
    $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=lessonandvideos&sub_page=educationalvideos&id=$id&grade_level=$grade_level";

    $query = "SELECT videos.id, videos.title, videos.filename, videos.type, videos.url FROM videos WHERE videos.id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $back_link = "/coordinator/educationalvideo/educationalvideos.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level&upload_option=upload"
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="LessonForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Learning Video Deleted Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Delete Lesson</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Title</label>
          <?php
            echo "<p class='field'>$row[title]</p>";
          ?>
        </div>
        
        <?php 
          if($row['type'] === 'upload'):
        ?>
          <div class="input">
            <label class="label">Filename</label>
            <?php
              echo "<p class='field'>$row[filename]</p>";
            ?>
          </div>
        <?php 
          else:
        ?>
          <div class="input">
            <label class="label">Link</label>
            <?php
              echo "<p class='field'>$row[url]</p>";
            ?>
          </div>
        <?php endif; ?>

        <input type="hidden" name="filename"  value="<?php echo $row['filename'] ?>" readonly/>
        <input type="hidden" name="id" value=<?php echo $row['id'] ?> />
        <p>Are you sure you want to delete this learning video?</p>
        <button class='button confirm-delete' type="submit">Yes</button>
        <a class='button cancel-delete' href="<?php echo $back_link ?>">No</a>
      </form>
    <?php endif; ?>
  </div>
</div>


<?php
  include '../../includes/html/footer.php';
?>