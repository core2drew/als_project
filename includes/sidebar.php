<div id="Sidebar">
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : null ?>" href="/dashboard.php">Dashboard</a>
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'lesson.php' ? 'active' : null ?>" href="/lessons.php">Lessons</a>
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'learningvideo.php' ? 'active' : null ?>" href="/learningvideo.php">Learning Video</a>
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'reviewer.php' ? 'active' : null ?>" href="/reviewer.php">Reviewer</a>
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'exam.php' ? 'active' : null ?>" href="/exam.php">Exam</a>
    <a class="btn <?php echo basename($_SERVER['PHP_SELF']) == 'examreviewer.php' ? 'active' : null ?>" href="/examreviewer.php">Exam Reviewer</a>
</div>