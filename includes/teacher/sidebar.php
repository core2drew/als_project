<?php
    if( $_SESSION['type'] == 'teacher'):
?>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : null ?>" href="/home.php">Home</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'announcements.php' ? 'active' : null ?>" href="/teacher/announcements.php">Announcement</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'students.php' ? 'active' : null ?>" href="/teacher/students.php">Students</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'lessons.php' ? 'active' : null ?>" href="/lessons.php">Lessons</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'educationalvideos.php' ? 'active' : null ?>" href="/educationalvideos.php">Educational Video</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'exams.php' ? 'active' : null ?>" href="/teacher/exams.php">A & E Test Reviewer</a>
    <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'quiz.php' || basename($_SERVER['PHP_SELF']) == 'questions.php' ? 'active' : null ?>" href="/teacher/quiz.php">Quiz</a>
<?php
    endif;
?>