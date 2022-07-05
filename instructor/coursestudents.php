<?php
/*
====================================================================
==  Manage Course Students Page
==  You can View || Remove || Approve Students From Course From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Students Control Panel"; 
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

        // start manage Students 
        if($action == 'manage')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $approve      = isset($_GET['approve']) && is_numeric($_GET['approve']) ? intval($_GET['approve']) :'';
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
                        if($approve == 0)
                        {
                            $students =getAllFrom
                            (
                                "`courses_students`.*,`courses`.`course_title`,`users`.*",
                                "courses_students",
                                "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                                "LEFT JOIN `users` ON `courses_students`.`student_id` =`users`.`user_id`",
                                "WHERE `courses_students`.`course_id` = $courseId",
                                "AND `courses_students`.`approved`= $approve"
                            );
                        }
                        else
                        {
                            $students =getAllFrom
                            (
                                "`courses_students`.*,`courses`.`course_title`,`users`.*",
                                "courses_students",
                                "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                                "LEFT JOIN `users` ON `courses_students`.`student_id` =`users`.`user_id`",
                                "WHERE `courses_students`.`course_id` = $courseId",
                                "AND `courses_students`.`approved`= 1"
                            );
                        }

                        require "./students/manageStudents.php";
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
        // End manage Students
        
        // start View Student Details 
        if($action == 'view')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $studentId    = isset($_GET['studentid']) && is_numeric($_GET['studentid']) ? intval($_GET['studentid']) :0;
            $instructorId = $_SESSION['user']['user_id'];

            if($courseId > 0)
            {
                $courseData = getAllFrom
                                    (
                                        "`courses`.*,`course_categories`.`category_name`" ,
                                        "courses",
                                        "LEFT JOIN `course_categories`",
                                        "ON `courses`.`course_category` = `course_categories`.`category_id`",
                                        "WHERE  `course_id` = $courseId",
                                        "LIMIT 1"
                                    );
                if(!empty($courseData))
                {
                    if($courseData[0]["course_instructor"] == $_SESSION['user']['user_id'])
                    {
                        if($studentId > 0)
                        {
                            if(isStudentJoinedCourse($studentId,$courseId))
                            {
                                $studentData =getAllFrom
                                (
                                    "*",
                                    "users",
                                    "",
                                    "",
                                    "WHERE `user_id`= $studentId",
                                    "LIMIT 1"
                                );
                                require "./students/studentdetails.php";
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
            else
            {
                require "../404.php";
            }
        }
        // End View Student Details

        // start Delete Students From Course
        if($action == 'delete')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $studentId    = isset($_GET['studentid']) && is_numeric($_GET['studentid']) ? intval($_GET['studentid']) :0;
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

                        if($studentId > 0)
                        {
                            if(isStudentJoinedCourse($studentId,$courseId))
                            {
                                // Delete Student From Course 
                                if(deleteStudentFromCourse($studentId,$courseId))
                                {
                                    $_SESSION['successMsg'] = "Student Delete Success ";
                                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/coursestudents.php?action=manage&courseid='.$courseId);
                                }
                                else
                                {
                                    $_SESSION['errors'] = "Something Went Wrong In Delete Student";
                                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/coursestudents.php?action=manage&courseid='.$courseId);
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
            else
            {
                require "../404.php";
            }
        }
        // End Delete Students From Course

        // start Approve Students From Course
        if($action == 'approve')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $studentId    = isset($_GET['studentid']) && is_numeric($_GET['studentid']) ? intval($_GET['studentid']) :0;
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

                        if($studentId > 0)
                        {
                            if(isStudentJoinedCourse($studentId,$courseId))
                            {
                                // Delete Student From Course 
                                if(confirmStudentSubscription($studentId,$courseId))
                                {
                                    $_SESSION['successMsg'] = "Student Approved Success ";
                                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/coursestudents.php?action=manage&courseid='.$courseId);
                                }
                                else
                                {
                                    $_SESSION['errors'] = "Something Went Wrong In Approved Student";
                                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/coursestudents.php?action=manage&courseid='.$courseId);
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
            else
            {
                require "../404.php";
            }
        }
        // End Approve Students From Course
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>