<?php
require  "./globals.php";
$pageTitle="Join Course";
include INCLUDES."/templates/front/header.php";

$courseId = isset($_GET['courseid']) && is_numeric($_GET['courseid']) ? intval($_GET['courseid']) :0;

#Get All Courses From DataBase . . . 
$course = getAllFrom
(
    "`courses`.*,`users`.`user_name`" ,
    "courses",
    "LEFT JOIN `users`",
    "ON `courses`.`course_instructor`=`users`.`user_id`",
    "WHERE `courses`.`course_id` = $courseId LIMIT 1",
);
if(!empty($course))
{
    // Start Mange Course Data Design . . . 
    require("./includes/templates/front/courseData.php");
    // End Mange Course Data Design . . . 
}
else
{
    header("location:404.php");
}
include INCLUDES."/templates/front/footer.php";
ob_end_flush();
?>