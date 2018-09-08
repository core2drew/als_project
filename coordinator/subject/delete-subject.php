<?php
    require '../../config/db_connect.php';
    include '../../includes/html/head.php';
    include '../../check_session.php';
    include '../../includes/header.php';
    include '../../resources/subject/delete.php';

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
    $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=subjects&id=$id&grade_level=$grade_level";

    $query = "SELECT subjects.id, subjects.title FROM subjects WHERE subjects.id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $back_link = "/coordinator/subject/subjects.php?page=subjects&grade_level=$grade_level"
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="AccountForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Subject Deleted Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Delete Subject</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Title</label>
          <?php 
            echo "<p class='field'>$row[title]</p>";
          ?>
        </div>
        <input type="hidden" name="id" value=<?php echo $row['id'] ?> />
        <p>Are you sure you want to delete this subject?</p>
        <button class='button confirm-delete' type="submit">Yes</button>
        <a class='button cancel-delete' href="/coordinator/subject/subjects.php?page=subjects&grade_level=1">No</a>
      </form>
    <?php endif; ?>
  </div>
</div>


<?php
  include '../../includes/html/footer.php';
?>