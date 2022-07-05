<?php
require  "../globals.php";
$pageTitle="My Courses";
$pageActive ="myCourses";
include ("../includes/templates/students/header.php");

if(!checkLogin())
{
    header("location:login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 4)
    {
        $studentId = intval($_SESSION['user']['user_id']);
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['searchValue']))
        {
            $searchInput = cleanInput($_POST['searchInp']);
            $errors = [];
                #Validate Title . . . . 
            if(!Validate($searchInput, "required"))
            {
                $errors[] ="Search Input Is Required ";
            }
            elseif(!Validate($searchInput, "min",3))
            {
                $errors[] ="Search Input Min length 3 Char ";
            }
            elseif(!Validate($searchInput, "string"))
            {
                $errors[] ="Search Input Must Be String ";
            }
            
            if(empty($errors))
            {
                $courses = getAllFrom
                (
                    "`courses_students`.* ,`courses`.* " ,
                    "courses_students",
                    "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                    "WHERE `courses_students`.`student_id` =$studentId",
                    "AND `courses_students`.`approved` = 1",
                    "AND `course_title` LIKE '%$searchInput%'"
                );
            }
            else
            {
                $courses = getAllFrom
                (
                    "`courses_students`.* ,`courses`.*",
                    "courses_students",
                    "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                    "WHERE `courses_students`.`student_id` = $studentId",
                    "AND `courses_students`.`approved` = 1",
                    null
                );
            }
        }
        else
        {
            $courses = getAllFrom
            (
                "`courses_students`.* ,`courses`.*",
                "courses_students",
                "LEFT JOIN `courses` ON `courses_students`.`course_id` = `courses`.`course_id`",
                "WHERE `courses_students`.`student_id` = $studentId",
                "AND `courses_students`.`approved` = 1",
                null
            );
        }
        // Start Mange Courses Design . . . 
        require("../includes/templates/students/manageCourses.php");
        // End Mange Courses Design . . . 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include ("../includes/templates/students/footer.php");
ob_end_flush();
?>