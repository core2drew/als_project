<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/learningvideo/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $upload_option =  isset($_GET['upload_option']) ? $_GET['upload_option'] : null;

  //Query all Subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=learningvideos&grade_level=$grade_level&upload_option=$upload_option";
  $back_link = "/coordinator/learningvideo/learningvideos.php?page=learningvideos&grade_level=$grade_level&upload_option=$upload_option";
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="LearningVideoForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Learning Video Created Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create Learning Video</h1>

      <div class="tabs">
        <?php
          $upload_options = array('upload', 'link');
          foreach($upload_options as $opt){
            $href = "/coordinator/learningvideo/create.php?page=learningvideos&grade_level=$grade_level&upload_option=$opt";
            $active_class = $opt === $upload_option ? " active'" : "'";
            $link = "<a class='tab". $active_class ." href=$href>$opt</a>";
            echo $link;
          }
        ?>
      </div>

      <form class="form" method="POST" action="<?php echo $form_action ?>" enctype="multipart/form-data">
        <div class="input">
          <label class="label">Subject</label>
          <select name="subject_id">
            <?php 
              $subjects_result = mysqli_query($conn, $subjects_query);
              $subjects_count = mysqli_num_rows($subjects_result);

              while($subject_row = mysqli_fetch_array($subjects_result, MYSQLI_ASSOC)) {
                if($row['id'] == $subject_row['id'] ) {
                  echo "<option value='$subject_row[id]' selected>$subject_row[title]</option>";
                } else {
                  echo "<option value='$subject_row[id]'>$subject_row[title]</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
          <?php echo isset($error_fields['title']) ? "<label class='error'>$error_fields[title]</label>" : null ?>
        </div>

        <div class="input" id="UploadVideo">
          <?php
            if($upload_option === 'upload'):
          ?>
            <label class="label">Upload Video</label>
            <input type="text" name="filename" readonly/>
            <input type="file" name="video_file" accept="video/mp4" value=''/>
            <?php echo isset($error_fields['video_file']) ? "<label class='error'>$error_fields[video_file]</label>" : null ?>
            <button class="btn upload-btn">Upload</button>
          <?php 
            else:
          ?>
            <label class="label">Video Link</label>
            <input type="hidden" name="filename" value=""/>
            <input type="text" name="video_link" value="<?php echo isset($_POST['video_link']) ? $_POST['video_link'] : '' ?>"/>
            <?php echo isset($error_fields['video_link']) ? "<label class='error'>$error_fields[video_link]</label>" : null ?>
          <?php endif ?>
        </div>
        
        <button class='button' type="submit">Create</button>

      </form>
    <?php endif; ?>
  </div>
</div>

<?php include '../../includes/html/scripts.php';?>
<script src="/public/js/modules/learning-video.js"></script>
<?php include '../../includes/html/footer.php'; ?>