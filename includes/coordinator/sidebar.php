<?php
    if( $_SESSION['type'] == 'coordinator'):
?>
    <?php if($_GET['page'] === 'home'): ?>
        <a class="button <?php echo $_GET['sub_page'] == 'home' ? 'active' : null ?>" href="/home.php?page=home&sub_page=home">Home</a>
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
        <a class="button <?php echo $_GET['sub_page'] == 'quiz' ? 'active' : null ?>" href="/coordinator/quiz-report.php?page=reports&sub_page=quiz&grade_level=1">Quiz</a>
        <a class="button <?php echo $_GET['sub_page'] == 'exam' ? 'active' : null ?>" href="/coordinator/exam-report.php?page=reports&sub_page=exam&grade_level=1">A & E Reviewer</a>
        <a class="button <?php echo $_GET['sub_page'] == 'itemanalysis' ? 'active' : null ?>" href="/coordinator/itemanalysis.php?page=reports&sub_page=itemanalysis&grade_level=1">Item Analysis</a>
    <?php endif ?>
<?php
    endif;
?>