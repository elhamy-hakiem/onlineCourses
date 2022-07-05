<?php 
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
?>

<div class="row">
    <aside class="profile-nav col-lg-3">
        <section class="panel">
            <div class="user-heading round">
                <?php
                    $userImage = $_SESSION['user']['user_image'];
                    if(!empty($userImage) && file_exists(UPLOADS."/users/".$userImage))
                    {
                ?>
                    <a><img src='<?php echo "../uploads/users/$userImage" ;?>' alt ='User Avatar'/></a>
                <?php 
                    }
                    else
                    {
                ?>
                    <a><img src='<?php echo "../uploads/users/default.png" ;?>' alt ='User Avatar'/></a>
                <?php 
                    }
                ?>
                <h1><?php echo $_SESSION['user']['user_name']  ;?></h1>
                <p><?php echo $_SESSION['user']['email'] ;?></p>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li><a><i class="icon-user"></i><strong><?php echo $_SESSION['user']['group_name'];?></strong></a></li>
            </ul>

        </section>
    </aside>
    <aside class="profile-info col-lg-9">
        <?php
            #Show Errors Or Success
            echo getErrors();
            echo getSuccessMsg();
            // Start Show Errors 
            if(!empty($errors))
            {
                echo '<div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="icon-remove"></i>
                </button>';
                foreach($errors as $key => $error)
                {
                    echo '<span><strong>'.$key.' : </strong>'.$error.'</span><br>';
                }
                echo '</div>';
            }
        ?>
        <section class="panel">
            <div class="panel-body bio-graph-info">
                <h1> Profile Info</h1>
                <form role="form" action="?action=profile" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $_SESSION['user']['user_name'] ;?>">
                    </div>
    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="hidden" name="oldpassword" value="<?php echo  $_SESSION['user']['password']?>">
                        <input type="password" class="form-control" placeholder="Enter Password" name="password">
                    </div>
    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Enter Email" name="useremail" value="<?php echo $_SESSION['user']['email'] ;?>">
                    </div>
    
                    <div class="form-group">
                        <label>Image</label>
                        <input type="hidden" name="oldImage" value="<?php echo  $_SESSION['user']['user_image']?>">
                        <input type="file" class="form-control" name="userImage">
                    </div>
    
                    <input type="submit" class="btn btn-success" value="Save" name="updateprofile">
                </form>    
            </div>
        </section>
    </aside>
</div>