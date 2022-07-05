<?php
require  "../globals.php";
$pageTitle="Lesson Comments";
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
        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : '' ;
        // End define action 

        // start Add lessons 
        if($action == 'add')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $lessonId     = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']) :0;
            $studentId    = $_SESSION['user']['user_id'];

            if($courseId > 0)
            {
                if(isApprovedJoinedCourse($studentId,$courseId))
                {
                    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addComment']))
                    {
                        #Errors Array
                        $errors = [];
                        $title         = cleanInput($_POST['commTitle']);
                        $content       = cleanInput($_POST['commContent']);
                        #Validate Title . . . . 
                        if(!Validate($title, "required"))
                        {
                            $errors["Title"] ="title Is Required ";
                        }
                        elseif(!Validate($title, "min",4))
                        {
                            $errors["Title"] ="title Min length 4 Char ";
                        }
                        elseif(!Validate($title, "max",20))
                        {
                            $errors["Title"] ="title Max length 20 Char ";
                        }
                        elseif(!Validate($title, "string"))
                        {
                            $errors["Title"] ="title Must Be String ";
                        }

                        #Validate content . . . . 
                        if(!Validate($content, "required"))
                        {
                            $errors["content"] ="content Is Required ";
                        }
                        elseif(!Validate($content, "min",5))
                        {
                            $errors["content"] ="content Min length 5 Char ";
                        }
                        elseif(!Validate($content, "string"))
                        {
                            $errors["content"] ="content Must Be String ";
                        }
                        // Check After Validate Data
                        if(empty($errors))
                        {
                            $tableName = "courses_lessons_comments";
                            $dataInputs = array(
                                "comment_title"        => $title,
                                "comment_content"      => $content,
                                "comment_lesson"       => $lessonId,
                                "comment_user"         => $studentId
                            );
                            if(Insert($tableName,$dataInputs))
                            {
                                $_SESSION['successMsg'] = "Comment Added Success";
                                header("location:lessondetails.php?courseid=$courseId&lessonid=$lessonId");
                            }
                            else
                            {
                                $_SESSION['errors'] = "somthing Went Wrong In Added Comment";
                                header("location:lessondetails.php?courseid=$courseId&lessonid=$lessonId");
                            }
                        }
                        else
                        {
                            foreach($errors as $error)
                            {
                                $_SESSION['errors'][] = $error."<br>";
                            }
                            header("location:lessondetails.php?courseid=$courseId&lessonid=$lessonId");
                        }

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

        // start Delete Lesson 
        if($action == 'delete')
        {
            $studentId   = $_SESSION['user']['user_id'];
            $courseId    = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $lessonId    = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;
            $commentId   = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;

            
            if($courseId > 0)
            {
                if(isApprovedJoinedCourse($studentId,$courseId))
                {
                    // get Lesson Data
                    $lessonComment =getAllFrom
                                            (
                                                "*" ,
                                                "courses_lessons_comments",
                                                "",
                                                "WHERE `comment_lesson`= $lessonId",
                                                "AND `comment_user` = $studentId",
                                                "AND `comment_id` = $commentId LIMIT 1"
                                            );
                    if(!empty($lessonComment))
                    {
                        if(Delete("courses_lessons_comments","WHERE `comment_lesson` = $lessonId AND `comment_id` = $commentId"))
                        {
                            $_SESSION['successMsg'] = "Comment Delete Success ";
                            header("location:lessondetails.php?courseid=$courseId&lessonid=$lessonId");
                        }
                        else
                        {
                            $_SESSION['errors'] = "Something Went Wrong In Delete Comment";
                            header("location:lessondetails.php?courseid=$courseId&lessonid=$lessonId");
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

        // if no action return lesson details 
        else
        {
            require "../404.php";
        }
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include ("../includes/templates/students/footer.php");
ob_end_flush();
?>    