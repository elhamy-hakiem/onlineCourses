<?php
require  "../globals.php";
$pageTitle="Lesson Data";
$pageActive ="myCourses";
include ("../includes/templates/students/header.php");

if(!checkLogin())
{
    header("location:../login.php");
}
else
{
    #Show Errors Or Success
    echo getErrors();
    echo getSuccessMsg();
    if($_SESSION['user']['user_group'] == 4)
    {
        $studentId    = $_SESSION['user']['user_id'];
        $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
        $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;

        if($courseId > 0)
        {
            if(isApprovedJoinedCourse($studentId,$courseId))
            {
                $lessonData =getAllFrom
                                    (
                                        "`courses_students`.*,`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name` AS instructor",
                                        "courses_students",
                                        "LEFT JOIN `courses_lessons` ON `courses_students`.`course_id`=`courses_lessons`.`lesson_course`",
                                        "LEFT JOIN `courses` ON `courses_students`.`course_id` =`courses`.`course_id`",
                                        "LEFT JOIN `users` ON `users`.`user_id`=`courses_lessons`.`lesson_instructor` WHERE `courses_students`.`course_id`=$courseId ",
                                        "AND `courses_students`.`student_id`=$studentId AND `courses_lessons`.`lesson_id`=$lessonId"
                                    );
                if(!empty($lessonData))
                {
                    require "../includes/templates/students/lessonData.php";
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
        else
        {
            require "../404.php";
        }
    }
}
include ("../includes/templates/students/footer.php");
ob_end_flush();
?>    
        