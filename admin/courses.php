<?php
/*
====================================================================
==  Manage Courses Page
==  You can View || Delete Courses From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Courses Control Panel"; 
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

        // start manage Courses 
        if($action == 'manage')
        {
            $categoryId = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :0;
            $userId = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) :0;

            if($categoryId > 0)
            {
                $courses = getAllFrom
                                    (
                                        "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                        "courses",
                                        " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                        " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                        "WHERE course_category = $categoryId",
                                        null
                                    );
            }
            elseif($userId > 0)
            {
                $courses = getAllFrom
                                    (
                                        "`courses`.* ,`users`.`user_name` ,`course_categories`.`category_name`" ,
                                        "courses",
                                        " LEFT JOIN `users` ON `courses`.`course_instructor` = `users`.`user_id`",
                                        " LEFT JOIN `course_categories` ON `courses`.`course_category` =`course_categories`.`category_id`",
                                        "WHERE course_instructor = $userId",
                                        null
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
                                        null,
                                        null
                                    );
            }
            require "./courses/manageCourses.php";
        }
        // End manage Courses


        // start Delete Courses 
        if($action == 'delete')
        {


            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;

            $courseData = getAllFrom("*" , "courses",  NULL, NULL,"WHERE `course_id` = $courseId ", "LIMIT 1");

            if(empty($courseData))
            {
                require "../404.php";
            }
            else
            {
                if(Delete("courses","WHERE `course_id` = $courseId"))
                {
                    $_SESSION['successMsg'] = "Course Delete Success ";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/courses.php');
                }
                else
                {
                    $_SESSION['errors'] = "Something Went Wrong In Delete Course";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/courses.php');
                }
            }
        }
        // End Delete Courses 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>