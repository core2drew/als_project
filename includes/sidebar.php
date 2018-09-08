<div id="Sidebar">
    
    <!-- Coordinator Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'coordinator' ):
    ?>
        <a class="button <?php echo basename($_GET['page']) == 'student' ? 'active' : null ?>" href="/coordinator/account/account.php?page=student&type=student&grade_level=1">Student</a>
        <a class="button <?php echo basename($_GET['page']) == 'teacher' ? 'active' : null ?>" href="/coordinator/account/account.php?page=teacher&type=teacher&grade_level=1">Teacher</a>
        <a class="button <?php echo basename($_GET['page']) == 'subjects' ? 'active' : null ?>" href="/coordinator/subject/subjects.php?page=subjects&grade_level=1">Subjects</a>
        <a class="button <?php echo basename($_GET['page']) == 'lessons' ? 'active' : null ?>" href="/coordinator/lesson/lessons.php?page=lessons&grade_level=1">Lessons</a>
        <a class="button <?php echo basename($_GET['page']) == 'learningvideos' ? 'active' : null ?>" href="/coordinator/learningvideo/learningvideos.php?page=learningvideos&grade_level=1">Learning Videos</a>
        <a class="button <?php echo basename($_GET['page']) == 'reviewandexams' ? 'active' : null ?>" href="/coordinator/reviewandexams.php?page=reviewandexams">Review and Exams</a>
        <a class="button <?php echo basename($_GET['page']) == 'reports' ? 'active' : null ?>" href="/coordinator/reports.php?page=reports">Reports</a>
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