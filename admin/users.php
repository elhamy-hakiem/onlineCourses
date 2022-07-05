<?php
/*
====================================================================
==  Manage Users Page
==  You can Add || Edite || Delete Users From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="EDUSITE Manage Users"; 
$pageTitle="Users Control Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/admin/sidebar.php";
if(!checkLogin())
{
    header("location:login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 1 || $_SESSION['user']['user_group'] == 2)
    {
        #Show Errors Or Success
        echo getErrors();
        echo getSuccessMsg();

        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'manage' ;
        // End define action 

        // start manage Users 
        if($action == 'manage')
        {
            require "./users/manageUser.php";
        }
        // End manage Users

        // start Add Users 
        if($action == 'add')
        {
            require "./users/adduser.php";
        }
        // End Add Users

        // start Update Users 
        if($action == 'update')
        {
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

            $userData = getAllFrom(
                "users.* ,users_groups.group_name" ,
                "users",
                "LEFT JOIN `users_groups`",
                " ON `users`.`user_group` = `users_groups`.`group_id`",
                "WHERE `users`.`user_id` = $userid",
                "LIMIT 1"
            );

            if(empty($userData))
            {
                require "../404.php";
            }
            else
            {
                if($userData[0]['user_group'] == 1 || $userData[0]['user_group'] == 2)
                {
                    if($_SESSION['user']['user_group'] == 1)
                    {
                        require "./users/updateuser.php";
                    }
                    else
                    {
                        $_SESSION['errors'] = "You Cant Update Admin";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                    }
                }
                else
                {
                    require "./users/updateuser.php";
                }
            }
        }
        // End Update Users 

        // start Delete Users 
        if($action == 'delete')
        {
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

            $userData = getAllFrom(
                "*" ,
                "users",
                "",
                "",
                "WHERE `user_id` = $userid",
                "LIMIT 1"
            );

            if(empty($userData))
            {
                require "../404.php";
            }
            else
            {
                #Start Super Admin Premission . . .  . .
                if($userData[0]['user_group'] == 1 || $userData[0]['user_group'] == 2)
                {
                    if($_SESSION['user']['user_group'] == 1)
                    {
                        // Delete User Image 
                        RemoveFile($userData[0]['user_image']);
                        // Delete User  . . . . 
                        if(Delete("users","WHERE `user_id` = $userid"))
                        {
                            $_SESSION['successMsg'] = "User Delete Success ";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                        }
                        else
                        {
                            $_SESSION['errors'] = "Something Went Wrong In Delete User";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                        }
                    }
                    else
                    {
                        $_SESSION['errors'] = "You Cant Delete Admin";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                    }
                }
                #End Super Admin Premission . . .  . .
                else
                {
                    if(Delete("users","WHERE `user_id` = $userid"))
                    {
                        $_SESSION['successMsg'] = "User Delete Success ";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                    }
                    else
                    {
                        $_SESSION['errors'] = "Something Went Wrong In Delete User";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/users.php');
                    }
                }
            }
        }
        // End Delete Users 

        // start Update Profile 
        if($action == 'profile')
        {
            require "./profile.php";
        }
        // End Update Profile 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>