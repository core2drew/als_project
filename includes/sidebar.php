<div id="Sidebar">
    
    <!-- Coordinator Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'coordinator'):
    ?>
        <?php if($_GET['page'] === 'home'): ?>
            <a class="button <?php echo $_GET['sub_page'] == 'activities' ? 'active' : null ?>" href="/coordinator/home.php?page=home&sub_page=activities">Activities</a>
            <a class="button <?php echo $_GET['sub_page'] == 'announcements' ? 'active' : null ?>" href="/coordinator/home.php?page=home&sub_page=announcements">Announcements</a>
        <?php elseif($_GET['page'] === 'accounts'): ?>
            <?php if($_SESSION['is_admin']): ?>
                <a class="button <?php echo $_GET['sub_page'] == 'coordinator' ? 'active' : null ?>" href="/coordinator/account.php?page=accounts&sub_page=coordinator&type=coordinator">Coordinator</a>
            <?php endif ?>
            <a class="button <?php echo $_GET['sub_page'] == 'teacher' ? 'active' : null ?>" href="/coordinator/account.php?page=accounts&sub_page=teacher&type=teacher&grade_level=1">Teacher</a>
            <a class="button <?php echo $_GET['sub_page'] == 'student' ? 'active' : null ?>" href="/coordinator/account.php?page=accounts&sub_page=student&type=student&grade_level=1">Student</a>
        <?php elseif($_GET['page'] === 'subjects'): ?>
            <a class="button <?php echo $_GET['page'] == 'subjects' ? 'active' : null ?>" href="/coordinator/subjects.php?page=subjects&grade_level=1">Subjects</a>
        <?php elseif($_GET['page'] === 'lessonandvideos'): ?>
            <a class="button <?php echo $_GET['sub_page'] == 'lessons' ? 'active' : null ?>" href="/coordinator/lessons.php?page=lessonandvideos&sub_page=lessons&grade_level=1">Lessons</a>
            <a class="button <?php echo $_GET['sub_page'] == 'educationalvideos' ? 'active' : null ?>" href="/coordinator/educationalvideos.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=1">Educational Videos</a>
        <?php elseif($_GET['page'] === 'examandquestions'): ?>
            <a class="button <?php echo $_GET['sub_page'] == 'questions' ? 'active' : null ?>" href="/coordinator/questions.php?page=examandquestions&sub_page=questions&grade_level=1">Questions</a>
            <a class="button <?php echo $_GET['sub_page'] == 'exams' ? 'active' : null ?>" href="/coordinator/exams.php?page=examandquestions&sub_page=exams&grade_level=1">Exams</a>
        <?php elseif($_GET['page'] === 'reports'): ?>
            <a class="button <?php echo $_GET['page'] == 'reports' ? 'active' : null ?>" href="/coordinator/reports.php?page=reports&grade_level=1">Reports</a>
        <?php endif ?>
    <?php
        endif;
    ?>

    <!-- Teacher Sidebar Menu-->
    <?php
        if( $_SESSION['type'] == 'teacher'):
    ?>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'announcements.php' ? 'active' : null ?>" href="/teacher/announcements.php">Announcement
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'students.php' ? 'active' : null ?>" href="/teacher/students.php">Students</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'lessons.php' ? 'active' : null ?>" href="/lessons.php">Lessons</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'educationalvideos.php' ? 'active' : null ?>" href="/educationalvideos.php">Educational Video</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'exams.php' ? 'active' : null ?>" href="/teacher/exams.php">A & E Test Reviewer</a>
        <a class="button <?php echo basename($_SERVER['PHP_SELF']) == 'quiz.php' || basename($_SERVER['PHP_SELF']) == 'questions.php' ? 'active' : null ?>" href="/teacher/quiz.php">Quiz</a>
    <?php
        endif;
    ?>

    <!-- Student Sidebar Menu-->
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

    <?php if(isset($_GET['page']) && $_GET['page'] === 'profile'): ?>
        <a class="button <?php echo $_GET['page'] == 'profile' ? 'active' : null ?>" href="/profile.php?page=profile">Profile</a>
    <?php endif ?>
</div>