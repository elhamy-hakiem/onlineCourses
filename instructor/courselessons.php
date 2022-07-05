<?php
/*
====================================================================
==  Manage Course Lessons Page
==  You can View || Add || Update || Delete Course Lessons From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Lessons Control Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/instructor/sidebar.php";
if(!checkLogin())
{
    header("location:../login.php");
}
else
{
    #Show Errors Or Success
    echo getErrors();
    echo getSuccessMsg();

    if($_SESSION['user']['user_group'] == 3)
    {
        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'manage' ;
        // End define action 

        // start manage lessons 
        if($action == 'manage')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $instructorId = $_SESSION['user']['user_id'];

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                    (
                                        "*" ,
                                        "courses",
                                        "",
                                        "",
                                        "WHERE  `course_id` = $courseId",
                                        ""
                                    );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        $lessons =getAllFrom
                                            (
                                                "`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name`",
                                                "courses_lessons",
                                                "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course` = `courses`.`course_id`",
                                                "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor` = `users`.`user_id`",
                                                "WHERE `courses_lessons`.`lesson_course` = $courseId"
                                            );
                        require "./lessons/manageLessons.php";
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
        // End manage lessons

        // start Add lessons 
        if($action == 'add')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $instructorId = $_SESSION['user']['user_id'];

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                    (
                                        "*" ,
                                        "courses",
                                        "",
                                        "",
                                        "WHERE  `course_id` = $courseId",
                                        ""
                                    );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        require "./lessons/addlesson.php";
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
        // End Add lessons

        // start View Lesson 
        if($action == 'view')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
            $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                        (
                                            "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                            "courses",
                                            " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                            " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                            "WHERE `courses`.`course_id` = $courseId",
                                            ""
                                        );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        // get Lesson Data
                        $lessonData =getAllFrom
                                                (
                                                    "`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name`" ,
                                                    "courses_lessons",
                                                    "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course` = `courses`.`course_id`",
                                                    "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor` = `users`.`user_id`",
                                                    "WHERE `courses_lessons`.`lesson_id` = $lessonId",
                                                    "AND `courses_lessons`.`lesson_course` = $courseId"
                                                ); 
                        require "./lessons/lessondetails.php";
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
        // End View Lesson

        // start Update Lesson 
        if($action == 'update')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
            $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                        (
                                            "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                            "courses",
                                            " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                            " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                            "WHERE `courses`.`course_id` = $courseId",
                                            ""
                                        );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        // get Lesson Data
                        $lessonupdate =getAllFrom
                                                (
                                                    "`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name`" ,
                                                    "courses_lessons",
                                                    "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course` = `courses`.`course_id`",
                                                    "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor` = `users`.`user_id`",
                                                    "WHERE `courses_lessons`.`lesson_id` = $lessonId",
                                                    "AND `courses_lessons`.`lesson_course` = $courseId LIMIT 1"
                                                );
                        if(!empty($lessonupdate))
                        {
                            require "./lessons/updatelesson.php";
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
            else
            {
                require "../404.php";
            }
        }
        // End Update Lesson

        // start Delete Lesson 
        if($action == 'delete')
        {

            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
            $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                        (
                                            "*" ,
                                            "courses",
                                            "",
                                            "",
                                            "WHERE `courses`.`course_id` = $courseId",
                                            ""
                                        );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        // get Lesson Data
                        $lessonData =getAllFrom
                                                (
                                                    "*" ,
                                                    "courses_lessons",
                                                    "",
                                                    "",
                                                    "WHERE `courses_lessons`.`lesson_id` = $lessonId",
                                                    "AND `courses_lessons`.`lesson_course` = $courseId LIMIT 1"
                                                );
                        if(!empty($lessonData))
                        {
                            // Delete Lesson Image 
                            RemoveFile($lessonData[0]["lesson_cover"],"../uploads/lessons/");
                            // Delete Lesson Video 
                            RemoveFile($lessonData[0]["lesson_video"],"../uploads/videos/");
                            // Delete Course 
                            if(Delete("courses_lessons","WHERE `lesson_id` = $lessonId AND `lesson_course` = $courseId"))
                            {
                                $_SESSION['successMsg'] = "Lesson Delete Success ";
                                header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/courselessons.php?action=manage&courseid='.$courseId);
                            }
                            else
                            {
                                $_SESSION['errors'] = "Something Went Wrong In Delete Lesson";
                                header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/courselessons.php?action=manage&courseid='.$courseId);
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
        // End Delete Lesson 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>