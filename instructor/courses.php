<?php
/*
====================================================================
==  Manage Courses Page
==  You can View || Add || Update || Delete Courses From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Course Control Panel"; 
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

        // start manage Courses 
        if($action == 'manage')
        {
            $categoryId   = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :0;
            $instructorId = $_SESSION['user']['user_id'];

            if($categoryId > 0)
            {
                $courses = getAllFrom
                                    (
                                        "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                        "courses",
                                        " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                        " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                        "WHERE `courses`.`course_category` = $categoryId",
                                        "AND `courses`.`course_instructor` = $instructorId ORDER BY `courses`.`course_id` DESC"
                                    );
            }
            else
            {
                $courses = getAllFrom
                                    (
                                        "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                        "courses",
                                        " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                        " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                        "WHERE `courses`.`course_instructor` = $instructorId",
                                        null
                                    );
            }

            require "./courses/manageCourses.php";
        }
        // End manage Courses

        // start Add Course 
        if($action == 'add')
        {
            require "./courses/addcourse.php";
        }
        // End Add Course

        // start View Course 
        if($action == 'view')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
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
                        // get Number Of Course Lessons
                        $courseLessons =getAllFrom
                                                (
                                                    "`courses_lessons`.*,`courses`.`course_title`,`users`.`user_name`" ,
                                                    "courses_lessons",
                                                    "LEFT JOIN `courses` ON `courses_lessons`.`lesson_course` = `courses`.`course_id`",
                                                    "LEFT JOIN `users` ON `courses_lessons`.`lesson_instructor` = `users`.`user_id`",
                                                    "WHERE `courses_lessons`.`lesson_course` = $courseId",
                                                    ""
                                                ); 
                        $numCourseLessons   = !empty($courseLessons) ? count($courseLessons) : 0;

                        // Get Number Of Course Students
                        $courseStudents =getAllFrom
                                                (
                                                    "`courses_students`.*,`courses`.`course_title`,`users`.*" ,
                                                    "courses_students",
                                                    "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                                                    "LEFT JOIN `users` ON `courses_students`.`student_id` =`users`.`user_id`",
                                                    "WHERE `courses_students`.`course_id`=$courseId",
                                                    "AND `courses_students`.`approved` = 1"
                                                ); 
                        $numCourseStudents   = !empty($courseStudents) ? count($courseStudents) : 0;

                        // Students Waiting Approves 
                        $studentsWaitingApproved =getAllFrom
                                                (
                                                    "`courses_students`.*,`courses`.`course_title`,`users`.*" ,
                                                    "courses_students",
                                                    "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                                                    "LEFT JOIN `users` ON `courses_students`.`student_id` =`users`.`user_id`",
                                                    "WHERE `courses_students`.`course_id` = $courseId",
                                                    "AND `courses_students`.`approved`= 0"
                                                ); 
                        $numStudentsWaitingApproved   = !empty($studentsWaitingApproved) ? count($studentsWaitingApproved) : 0;

                        require "./courses/coursedetails.php";
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
        // End View Course

        // start Update Course 
        if($action == 'update')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']):0;
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
                        require "./courses/updatecourse.php";
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
        // End Update Course

        // start Delete Course 
        if($action == 'delete')
        {
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;

            $courseData = getAllFrom("*" , "courses",  NULL, NULL,"WHERE `course_id` = $courseId ", "LIMIT 1");
            if($courseId > 0)
            {
                if(empty($courseData))
                {
                    require "../404.php";
                }
                else
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        // Delete Course Image 
                        RemoveFile($courseData[0]["course_cover"],"../uploads/courses/");
                        // Delete Course 
                        if(Delete("courses","WHERE `course_id` = $courseId"))
                        {
                            $_SESSION['successMsg'] = "Course Delete Success ";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/courses.php');
                        }
                        else
                        {
                            $_SESSION['errors'] = "Something Went Wrong In Delete Course";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/courses.php');
                        }
                    }
                    else
                    {
                        require "../404.php";
                    }
                }
            }
            else
            {
                require "../404.php";
            }
        }
        // End Delete Course 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>