<?php
    if( $_SESSION['type'] == 'student' && !isset($_GET['page'])):
?>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : null ?>" href="/home.php">Home</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'lessons.php' ? 'active' : null ?>" href="/lessons.php">Lessons</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'educationalvideos.php' ? 'active' : null ?>" href="/educationalvideos.php">Educational Video</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'exams.php' ? 'active' : null ?>" href="/exams.php">A & E Test Reviewer</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'quiz.php' ? 'active' : null ?>" href="/quiz.php">Quiz</a>
<?php
    endif;
?>