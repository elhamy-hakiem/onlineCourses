<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateuser']))
    {
        $userid       = intval($_POST['userid']);
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

        #User Group Data . . . 
        $usergroup = (isset($_POST["usergroup"]) && !empty($_POST["usergroup"])) ? intval($_POST["usergroup"]): 0;
        
        if($_SESSION['user']['user_group'] == 1)
            $usergroupArray = array(1,2,3,4);
        else
            $usergroupArray = array(3,4);

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

        #Validate User Group . . . . 
        if(!Validate($usergroup, "required"))
        {
            $errors["UserGroup"] ="User Type Is Required ";
        }
        if(!in_array($usergroup,$usergroupArray))
        {
            $errors["UserGroup"] ="User Type Not Correct";
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
                "user_image" =>$finalImageName,
                "user_group" => $usergroup
            );
            if(Update($tableName,$dataInputs,"WHERE `user_id` = $userid"))
            {
                $_SESSION['successMsg'] = "User Updated Success";
                header("refresh:1.5;url=".$_SERVER['PHP_SELF']."?action=update&userid=$userid");
            }
            else
            {
                $_SESSION['errors'] = "No Data Changed In Update";
                header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=update&userid=$userid");
            }
        }
    }
?>

<div class="row">
    <!-- Start Show User Image  -->
    <aside class="profile-nav col-lg-3">
        <section class="panel">
            <div class="user-heading round">
                <?php
                    $userImage = $userData[0]['user_image'];
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
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li><a><i class="icon-user"></i><strong><?php echo $userData[0]['group_name'];?></strong></a></li>
            </ul>

        </section>
    </aside>
    <!-- End Show User Image  -->
    <!-- Start Show User Data  -->
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
            <header class="panel-heading">
                Update User
            </header>
            <div class="panel-body">
                <form role="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=update&userid=$userid ";?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userid" value="<?php echo $userid ;?>">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $userData[0]['user_name']?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="hidden" name="oldpassword" value="<?php echo $userData[0]['password']?>">
                        <input type="password" class="form-control" placeholder="Enter Password" name="password">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Enter Email" name="useremail" value="<?php echo $userData[0]['email']?>">
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="hidden" name="oldImage" value="<?php echo $userData[0]['user_image']?>">
                        <input type="file" class="form-control" name="userImage">
                    </div>

                    <div class="form-group">
                        <label>User Group</label>
                        <select name="usergroup"  class="form-control">
                            <option value="" >choose User Group</option>
                            <?php
                                #Check Admin Premission .  .  .
                                if($_SESSION['user']['user_group'] == 2)
                                {
                                    $groups = getAllFrom(
                                        "*" ,
                                        "users_groups",
                                        "",
                                        "",
                                        "WHERE `group_id` != 1",
                                        "AND `group_id` != 2"
                                    );
                                }
                                else
                                {
                                    $groups = getAllFrom(
                                        "*" ,
                                        "users_groups",
                                        "",
                                        "",
                                        "",
                                        null
                                    );
                                }
                                foreach($groups as $group)
                                {
                                    $groupId   = $group['group_id'];
                                    $groupName = $group['group_name'];
                                    echo '<option value="'.$groupId.'"';
                                        if($groupId == $userData[0]['user_group'])
                                            echo 'selected';
                                    echo '>'.$groupName.'</option>';
                                } 
                            ?>
                        </select> 
                    </div>


                    <input type="submit" class="btn btn-success" value="Update User" name="updateuser">
                </form>

            </div>
        </section>
    </aside>
</div>
