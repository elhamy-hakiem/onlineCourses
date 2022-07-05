<?php
require  "../globals.php";
$pageTitle="Course Lessons";
$pageActive ="myCourses";
include ("../includes/templates/students/header.php");

if(!checkLogin())
{
    header("location:../login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 4)
    {
        $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
        $studentId    = $_SESSION['user']['user_id'];

        if($courseId > 0)
        {
            if(isApprovedJoinedCourse($studentId,$courseId))
            {
                $lessons =getAllFrom
                                    (
                                        "`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name`",
                                        "courses_lessons",
                                        "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course`=`courses`.`course_id`",
                                        "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor`=`users`.`user_id`",
                                        "WHERE `courses_lessons`.`lesson_course`=$courseId",
                                        ""
                                    );
                require "../includes/templates/students/manageLessons.php";
            }
            else
            {
                require "../404.php";
            }
        }
        else
        {
            require "../404.php";
        }
    }
}
include ("../includes/templates/students/footer.php");
ob_end_flush();
?>    