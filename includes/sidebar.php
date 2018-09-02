<div id="Sidebar">
    
    <!-- Coordinator Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'coordinator' ):
    ?>
        <a class="button <?php echo basename($_GET['type']) == 'student' ? 'active' : null ?>" href="/coordinator/account.php?type=student">Student</a>
        <a class="button <?php echo basename($_GET['type']) == 'teacher' ? 'active' : null ?>" href="/coordinator/account.php?type=teacher">Teacher</a>
    <?php
        endif;
    ?>

    <!-- Teacher Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'teacher' ):
    ?>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'student.php' ? 'active' : null ?>" href="/teacher/student.php">Students</a>
    <?php
        endif;
    ?>

    <!-- Student Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'student' ):
    ?>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : null ?>" href="/dashboard.php">Dashboard</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'lesson.php' ? 'active' : null ?>" href="/lessons.php">Lessons</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'learningvideo.php' ? 'active' : null ?>" href="/learningvideo.php">Learning Video</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'reviewer.php' ? 'active' : null ?>" href="/reviewer.php">Reviewer</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'exam.php' ? 'active' : null ?>" href="/exam.php">Exam</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'examreviewer.php' ? 'active' : null ?>" href="/examreviewer.php">Exam Reviewer</a>
    <?php
        endif;
    ?>
</div>