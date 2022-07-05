<?php
    require  "./globals.php";
    $pageTitle ="Courses";
    $pageActive ="courses";
    include INCLUDES."/templates/front/header.php";

    // Start define action 
    $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'manage' ;
    // End define action 

    // start manage Courses 
    if($action == 'manage')
    {
        $categoryId = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :0;

        #Get All Categories From DataBase . . . 
        $categories =getAllFrom
                                (
                                    "*" ,
                                    "course_categories",
                                    "",
                                    "",
                                    "ORDER BY `category_id` DESC",
                                    "LIMIT 8"
                                );
        #Get All Courses From DataBase . . . 
        if($categoryId > 0)
        {
            $courses = getAllFrom
            (
                "*" ,
                "courses",
                "WHERE `course_category`=$categoryId",
                "ORDER BY `course_id` DESC",
                null,
                null
            );
        }
        else
        {
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['searchCourse']))
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
                        "*" ,
                        "courses",
                        "WHERE `course_title` LIKE '%$searchInput%'",
                        null,
                        null,
                        null
                    );
                }
            }
            else
            {
                $courses = getAllFrom
                (
                    "*" ,
                    "courses",
                    "ORDER BY `course_id` DESC",
                    null,
                    null,
                    null
                );
            }
        }
        // Start Mange Courses Design . . . 
        require("./includes/templates/front/manageCourses.php");
        // End Mange Courses Design . . . 
    }
    //End Manage Course

    // Start Join To Course 
    if($action == 'join')
    {
        if($_SESSION['user']['user_group'] == 4)
        {   
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $studentId = intval($_SESSION['user']['user_id']);
            
            if(isStudentJoinedCourse($studentId,$courseId))
            {
                $_SESSION['errors'] = "You are Already Join To This Course";
                header("location:coursedetails.php?courseid=".$courseId."");
            }
            else
            {
                if(addStudentToCourse($studentId,$courseId))
                {
                    $_SESSION['successMsg'] = "Success Join To This Course";
                    header("location:coursedetails.php?courseid=".$courseId."");
                }
                else
                {
                    $_SESSION['errors'] = "Something Went Wrong in Join To This Course";
                    header("location:coursedetails.php?courseid=".$courseId."");
                }
            }
        }
        else
        {
            header("location:404.php");
        }
    }
    // End Join To Course 

    // Start Delete From Course 
    if($action == 'delete')
    {
        if($_SESSION['user']['user_group'] == 4)
        {   
            $courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $studentId = intval($_SESSION['user']['user_id']);
            
            if(isApprovedJoinedCourse($studentId,$courseId))
            {
                $_SESSION['errors'] = "You Cant Delete From This Course";
                header("location:coursedetails.php?courseid=".$courseId."");
            }
            else
            {
                if(!isStudentJoinedCourse($studentId,$courseId))
                {
                    $_SESSION['errors'] = "You Are Not Join In This Course";
                    header("location:coursedetails.php?courseid=".$courseId."");
                }
                else
                {
                    if(deleteStudentFromCourse($studentId,$courseId))
                    {
                        $_SESSION['successMsg'] = "You  Deleted From This Course";
                        header("location:coursedetails.php?courseid=".$courseId."");
                    }
                    else
                    {
                        $_SESSION['errors'] = "Something Went Wrong in Delete From This Course";
                        header("location:coursedetails.php?courseid=".$courseId."");
                    }
                }
            }
        }
        else
        {
            header("location:404.php");
        }
    }
    // End Delete From Course 

    include INCLUDES."/templates/front/footer.php";
    ob_end_flush();
?>