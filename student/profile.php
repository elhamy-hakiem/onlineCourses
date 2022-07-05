<?php
require  "../globals.php";
$pageTitle="My Profile";
$pageActive ="myProfile";
include ("../includes/templates/students/header.php");
if(!checkLogin())
{
    header("location:login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 4)
    { 
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateprofile']))
        {
            $userid       = intval($_SESSION['user']['user_id']);
            $name         = cleanInput($_POST['username']);
            $email        = cleanInput($_POST['useremail']);
            $newPassword  = cleanInput($_POST['password']);
            $oldpassword  = cleanInput($_POST['oldpassword']);
            $oldImage     = $_POST['oldImage'];
            #Image Data . . . 
            $newImage       = $_FILES['userImage'];
            $newImageName   = $newImage['name'];
            $newImageType   = $newImage['type'];
            $newImageSize   = $newImage['size'];
            $newImageTmp    = $newImage['tmp_name'];
            $finalImageName = "";

            #Errors Array
            $errors = [];

            #Validate Name . . . . 
            if(!Validate($name, "required"))
            {
            $errors["username"] ="User Is Required ";
            }
            elseif(!Validate($name, "min"))
            {
            $errors["username"] ="User Min length 6 Char ";
            }
            elseif(!Validate($name, "string"))
            {
            $errors["username"] ="User Must Be String ";
            }

            #Validate Eamil . . . . 
            $user = getAllFrom(
            "email" ,
            "users",
            "",
            "",
            "WHERE `email`= '$email'",
            "AND `user_id` != $userid LIMIT 1"
            );
            if(!empty($user))
            {
                $errors["Eamil"] ="Email Already Exist Insert Another";
            }
            elseif(!Validate($email, "required"))
            {
                $errors["Eamil"] ="Eamil Is Required ";
            }
            elseif(!Validate($email, "email"))
            {
                $errors["Eamil"] ="Eamil  Is Not Valid ";
            }

            #Validate Password . . . . 
            if(Validate($newPassword, "required"))
            {
                if(!Validate($newPassword, "password"))
                {
                    $errors["Password"] ="Password  Is Not Correct ";
                }
                else
                {
                    $newPassword = hashPasswords($newPassword);
                }
            }
            else
            {
                if(!empty($oldpassword))
                {
                    $newPassword = $oldpassword;
                }
            }
            #Validate User Image . . . . 
            if(Validate($newImageName, "required"))
            {
                if(!Validate($newImageType, "fileExtension",null,['png', 'jpg', 'jpeg', 'webp']))
                {
                    $errors["userImage"] ="Image Type Is Not Correct ";
                }
                elseif(!Validate($newImageSize, "fileSize",null,null,716800))
                {

                    $errors["userImage"] ="Image Must Be Not Greater Than 600 KB ";
                }
                else
                {
                    if(!empty($oldImage))
                    {
                        RemoveFile($oldImage);
                    }
                }
            }
            else
            {
                if(empty($oldImage))
                {
                    $errors["userImage"] ="Image Is Required ";
                }
                else
                {
                    $finalImageName = $oldImage;
                }
            }


            if(empty($errors))
            {
                if(empty($finalImageName))
                {
                    $checkUpload =UploadFile($newImageType,$newImageTmp,"../uploads/users/");
                    if($checkUpload)
                    {
                        $finalImageName = $checkUpload ;
                    }
                    else
                    {
                        $errors["userImage"] ="Something Went Wrong In Image Upload ";
                    }
                }

                $tableName = "users";
                $dataInputs = array(
                    "user_name"  => $name,
                    "email"      => $email,
                    "password"   => $newPassword,
                    "user_image" =>$finalImageName
                );
                if(Update($tableName,$dataInputs,"WHERE `user_id` = $userid"))
                {
                    $_SESSION['successMsg'] = "Profile Updated Success";
                    $updatedData =getUserById($userid);
                    $_SESSION['user'] = $updatedData[0];

                    header("refresh:1;url=".$_SERVER['PHP_SELF']."?action=profile");
                }
                else
                {
                    $_SESSION['errors'] = "NO Data Changed In Update your Profile";
                    header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=profile");
                }
            }
        }
        // Show Profile Data Design 
        require("../includes/templates/students/profileData.php");
    }
}
include ("../includes/templates/students/footer.php");
ob_end_flush();
?>
