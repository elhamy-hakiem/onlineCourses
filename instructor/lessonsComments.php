<?php
/*
====================================================================
==  Manage Lessons Comments Page
==  You can View || Add || Update || Delete Lessons Comments From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Lessons Comments Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/instructor/sidebar.php";
if(!checkLogin())
{
    header("location:../login.php");
}
else
{

    if($_SESSION['user']['user_group'] == 3)
    {
        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : '' ;
        // End define action 

        // start Add lessons 
        if($action == 'add')
        {
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $lessonId     = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']) :0;
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
                    $lessonData = getAllFrom
                                    (
                                        "*" ,
                                        "courses_lessons",
                                        "",
                                        "",
                                        "WHERE  `lesson_id` = $lessonId",
                                        ""
                                    );
                    if(!empty($lessonData))
                    {
                        if($lessonData[0]["lesson_instructor"] == $_SESSION['user']['user_id'])
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
                                        "comment_user"         => $_SESSION['user']['user_id']
                                    );
                                    if(Insert($tableName,$dataInputs))
                                    {
                                        $_SESSION['successMsg'] = "Comment Added Success";
                                        header("refresh:1;url=courselessons.php?action=view&courseid=$courseId&lessonid=$lessonId");
                                    }
                                    else
                                    {
                                        $_SESSION['errors'] = "somthing Went Wrong In Added Comment";
                                        header("refresh:2;url=courselessons.php?action=view&courseid=$courseId&lessonid=$lessonId");
                                    }
                                }
                                else
                                {
                                    foreach($errors as $error)
                                    {
                                        $_SESSION['errors'][] = $error."<br>";
                                    }
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
            $instructorId = $_SESSION['user']['user_id'];
            $courseId     = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;
            $lessonId = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? intval($_GET['lessonid']):0;
            $commentId = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;

            
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
                    if($lessonId > 0)
                    {
                        $lessonData = getAllFrom
                                                (
                                                    "*" ,
                                                    "courses_lessons",
                                                    "",
                                                    "",
                                                    "WHERE `lesson_id` = $lessonId",
                                                    ""
                                                );
                        if(!empty($lessonData))
                        {
                            if($lessonData[0]["lesson_instructor"] == $_SESSION['user']['user_id'])
                            {
                                // get Lesson Data
                                $lessonComment =getAllFrom
                                                        (
                                                            "*" ,
                                                            "courses_lessons_comments",
                                                            "",
                                                            "",
                                                            "WHERE `comment_lesson`= $lessonId",
                                                            "AND `comment_id` = $commentId LIMIT 1"
                                                        );
                                if(!empty($lessonComment))
                                {
                                    if(Delete("courses_lessons_comments","WHERE `comment_lesson` = $lessonId AND `comment_id` = $commentId"))
                                    {
                                        $_SESSION['successMsg'] = "Comment Delete Success ";
                                        header("location:courselessons.php?action=view&courseid=$courseId&lessonid=$lessonId");
                                    }
                                    else
                                    {
                                        $_SESSION['errors'] = "Something Went Wrong In Delete Comment";
                                        header("location:courselessons.php?action=view&courseid=$courseId&lessonid=$lessonId");
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
            else
            {
                require "../404.php";
            }
        }
        // End Delete Lesson

        // if no action return lesson details 
        else
        {
            header("location:courselessons.php?action=view&courseid=$courseId&lessonid=$lessonId");
        }
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>