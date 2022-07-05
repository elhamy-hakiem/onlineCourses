<?php
/*
====================================================================
==  Manage Users Groups Page
==  You can Add || Edite || Delete Users Groups From Here
====================================================================
*/
require  "../globals.php";
$pageTitle="Groups Control Panel"; 
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

        // start manage Users 
        if($action == 'manage')
        {
            require "./usersGroup/manageUserGroups.php";
        }
        // End manage Users

        // start Add Users Groups
        if($action == 'add')
        {
            require "./usersGroup/addusergroup.php";
        }
        // End Add Users Groups

        // start Update Users Groups 
        if($action == 'update')
        {
            $groupId = isset($_GET['gid']) && is_numeric($_GET['gid']) ? intval($_GET['gid']) :0;

            $groupData = getAllFrom("*" , "users_groups",  NULL, NULL,"WHERE `group_id` = $groupId ", "LIMIT 1");

            if(empty($groupData))
            {
                require "../404.php";
            }
            else
            {
                if($groupData[0]['group_id'] == 1 || $groupData[0]['group_id'] == 2)
                {
                    if($_SESSION['user']['user_group'] == 1)
                    {
                        require "./usersGroup/updateusergroup.php";
                    }
                    else
                    {
                        $_SESSION['errors'] = "You Dont Have Premission To Update This Group";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                    }
                }
                else
                {
                    require "./usersGroup/updateusergroup.php";
                }
            }
        }
        // End Update Users Groups 

        // start Delete Users Groups 
        if($action == 'delete')
        {
            $groupId = isset($_GET['gid']) && is_numeric($_GET['gid']) ? intval($_GET['gid']) :0;

            $groupData = getAllFrom("*" , "users_groups",  NULL, NULL,"WHERE `group_id` = $groupId ", "LIMIT 1");

            if(empty($groupData))
            {
                require "../404.php";
            }
            else
            {
                #Start Super Admin Premission . . .  . .
                if($groupData[0]['group_id'] == 1 || $groupData[0]['group_id'] == 2)
                {
                    if($_SESSION['user']['user_group'] == 1)
                    {
                        if(Delete("users_groups","WHERE `group_id` = $groupId"))
                        {
                            $_SESSION['successMsg'] = "Group Delete Success ";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                        }
                        else
                        {
                            $_SESSION['errors'] = "Something Went Wrong In Delete Group";
                            header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                        }
                    }
                    else
                    {
                        $_SESSION['errors'] = "You Dont Have Premission To Delete This Group";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                    }
                }
                #End Super Admin Premission . . .  . .
                else
                {
                    if(Delete("users_groups","WHERE `group_id` = $groupId"))
                    {
                        $_SESSION['successMsg'] = "Group Delete Success ";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                    }
                    else
                    {
                        $_SESSION['errors'] = "Something Went Wrong In Delete Group";
                        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/usersgroups.php');
                    }
                }
            }
        }
        // End Delete Users Groups 
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>