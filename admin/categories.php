<?php
/*
====================================================================
==  Manage Categories Page
==  You can Add || Edite || Delete Categories From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Categories Control Panel"; 
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

        // start manage Categories 
        if($action == 'manage')
        {
            require "./categories/manageCategories.php";
        }
        // End manage Categories

        // start Add Categories
        if($action == 'add')
        {
            require "./categories/addcategory.php";
        }
        // End Add Categories

        // start Update Categories
        if($action == 'update')
        {
            $categoryId = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;

            $categoryData = getAllFrom("*" , "course_categories",  NULL, NULL,"WHERE `category_id` = $categoryId ", "LIMIT 1");

            if(empty($categoryData))
            {
                require "../404.php";
            }
            else
            {
                require "./categories/updatecategory.php";
            }
        }
        // End Update Categories

        // start Delete Categories 
        if($action == 'delete')
        {


            $categoryId = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;

            $categoryData = getAllFrom("*" , "course_categories",  NULL, NULL,"WHERE `category_id` = $categoryId ", "LIMIT 1");

            if(empty($categoryData))
            {
                require "../404.php";
            }
            else
            {
                if(Delete("course_categories","WHERE `category_id` = $categoryId"))
                {
                    $_SESSION['successMsg'] = "Category Delete Success ";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/categories.php');
                }
                else
                {
                    $_SESSION['errors'] = "Something Went Wrong In Delete Category";
                    header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/categories.php');
                }
            }
        }
        // End Delete Categories 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>