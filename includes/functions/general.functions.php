<?php
//  Function to change page title 
//version(1.0)
function getTitle()
{
    global $pageTitle ;
    if(isset($pageTitle)){echo $pageTitle;}
    else{echo "Default";}
}
//  Function to change Link Active 
//version(1.0)
function pageActive($title)
{
    global $pageActive ;
    if(isset($pageActive) && $pageActive == "$title"){echo "class = 'active'";}
    else{echo "";}
}
############################################################################
/**
 * Login user by Email And Password
 * @param string $email
 * @param string $password 
 * @return bool
 */
function login($email,$password)
{
    $status = true;
    $user = getAllFrom(
                        "users.* ,users_groups.group_name" ,
                        "users",
                        "LEFT JOIN `users_groups`",
                        " ON `users`.`user_group` = `users_groups`.`group_id`",
                        "WHERE `users`.`email` = '$email'",
                        "LIMIT 1"
                    );                    
    if(!empty($user))
    {
        $hashedPassword = $user[0]['password'];
        if(password_verify($password,$hashedPassword))
        {
            $_SESSION['user']=$user[0];
            $status = true;
        }
        else
        {
            $_SESSION['errors']= "Password Is Not Correct";
            $status = false;
        }
    }
    else
    {
        $_SESSION['errors']= "Invalid Email Or Password";
        $status = false;
    }
    return $status;
}
###########################################################################
/**
 * check login 
 */
function checkLogin()
{
    if(isset($_SESSION['user']))
        return true;
}
#########################################################################
/**
 * check Correct User Redirect  After Login
 */
function invalidRedirect($userGroup)
{
    if ($userGroup == 1 || $userGroup == 2 )
    {
        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/admin/index.php');
        exit();
    }
    elseif ($userGroup == 3)
    {
        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/instructor/index.php');
        exit();
    }
    elseif($userGroup == 4)
    {
        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/student/index.php');
        exit();
    }
    else
        header('location:http://'.$_SERVER['HTTP_HOST'].'/onlineCourses/index.php');
        exit();
}
##########################################################################
//  Function to Get Errors From Session 
function getErrors()
{
    if(isset($_SESSION['errors']) && !empty($_SESSION['errors']))
    {
        $errors = $_SESSION['errors'];
        $HTMLerrors = '<div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>';
        if(!is_string($errors))
        {
            foreach($errors as $error)
            {
                $HTMLerrors .= '<span>'.$error.'</span>';
            }
        }
        else
        {
            $HTMLerrors .= '<span>'.$errors.'</span>';
        }
        $HTMLerrors .= '</div>';

        $_SESSION['errors'] = [];
        return $HTMLerrors;
    }
    return null;
}

############################################################################
//  Function to Get Success Message From Session 
function getSuccessMsg()
{
    if( isset($_SESSION['successMsg']) && !empty($_SESSION['successMsg']) )
    {
        echo '<div class="alert alert-success alert-block fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="icon-remove"></i>
                </button>
                <h4>
                    <i class="icon-ok-sign"></i>
                    Success!
                </h4><span>';
            echo $_SESSION['successMsg'];
        echo '</span></div>';
        $_SESSION['successMsg'] = '';
    }
    return null;
}
############################################################################
/**
 * Hashed Password Function
 * @param password
 * @return string
 */
function hashPasswords($password)
{
    return password_hash($password,PASSWORD_DEFAULT);
}
############################################################################
/**
 * Clean Input Function
 * @param Input
 * @return string
 */
function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = strip_tags($input);
    return $input;
}

# Validate Function to validate the data 
function Validate($input, $case, $length = 6,$allowedExtensions=null,$fileSizeLimit = null)
{

    $status = true;

    switch ($case) {

        case 'required':
            if (empty($input)) {
                $status = false;
            }
            break;

        case 'email':
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;

        case 'password':
            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $input)) 
            {
                $status = false;
            }
            break;


        case 'min':
            if (strlen($input) < $length) {
                $status = false;
            }
            break;

        case 'string':
            if (!is_string($input)) {
                $status = false;
            }
            break;

        case 'max':
            if (strlen($input) > $length) {
                $status = false;
            }
            break;

        case 'int':
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;

        case 'fileExtension':

            # Validate Extension . . . 
            $fileType = $input;
            $extensionArray = explode('/', $fileType);
            $extension =  strtolower(end($extensionArray));

            if (!in_array($extension, $allowedExtensions)) {

                $status = false;
            }

            break;
            case 'fileSize':

                # Validate Extension . . . 
                $fileSize = $input;
                if ($fileSize > $fileSizeLimit) {
    
                    $status = false;
                }
    
                break;
        case 'date':
            $dateArray = explode('-', $input);

            if (!checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
                $status = false;
            }
            break;
    }


    return $status;
}

# Upload . . . 
function UploadFile($fileType,$fileTmp,$destination)
{
    $extensionArray = explode('/', $fileType);
    $extension =  strtolower(end($extensionArray));
    # Upload Image . . .
    $finalName =  md5(rand(0,100000000)) . '.' . $extension;
    if(is_uploaded_file($fileTmp))
    {
        if(move_uploaded_file($fileTmp,"$destination".$finalName))
        {
            return $finalName;
        }
        else
        {
            return false;
        }
    }
    
}



# Remove File 
function RemoveFile($file,$destination ="../uploads/users/")
{
    $filePath = "$destination" . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        $status = true;
    } else {
        $status = false;
    }
    return $status;
}

