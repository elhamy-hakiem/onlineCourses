<?php
/*
====================================================================
==  Manage Lessons Page
==  You can View || Delete Lessons From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Lessons Control Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/admin/sidebar.php";
if(!checkLogin())
{
    header("location:login.php");
}
else
{
    #Show Errors Or Success
    echo getErrors();
    echo getSuccessMsg();

    if($_SESSION['user']['user_group'] == 1 || $_SESSION['user']['user_group'] == 2)
    {
        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'manage' ;
        // End define action 

        // start manage Lessons 
        if($action == 'manage')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
                #Get course Title  . . . 
                $course = getAllFrom
                                    (
                                        "course_title" ,
                                        "courses",
                                        null,
                                        null,
                                        "WHERE course_id = $courseId",
                                        null
                                    );

                #Get All Lessons  . . . 
                $lessons = getAllFrom
                                    (
                                        "`courses_lessons`.* , `users`.`user_name` ,`courses`.`course_title`" ,
                                        "courses_lessons",
                                        "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor` = `users`.`user_id`",
                                        "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course` = `courses`.`course_id`",
                                        "WHERE lesson_course = $courseId",
                                        null
                                    );

            require "./lessons/manageLessons.php";
        }
        // End manage Courses


        // start Delete Courses 
        if($action == 'delete')
        {

            $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']) :0;
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;

            $lessonData = getAllFrom("*" , "courses_lessons",  NULL, NULL,"WHERE `lesson_id` = $lessonId ", "AND `lesson_course` = $courseId LIMIT 1");

            if(empty($lessonData))
            {
                require "../404.php";
            }
            else
            {
                if(Delete("courses_lessons","WHERE `lesson_id` = $lessonId AND `lesson_course` = $courseId"))
                {
                    $_SESSION['successMsg'] = "Lesson Delete Success ";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/courselessons.php');
                }
                else
                {
                    $_SESSION['errors'] = "Something Went Wrong In Delete Lesson";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/courselessons.php');
                }
            }
        }
        // End Delete Lessons 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>