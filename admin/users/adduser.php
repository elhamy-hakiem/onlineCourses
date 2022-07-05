<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['adduser']))
    {
        $name         = cleanInput($_POST['username']);
        $email        = cleanInput($_POST['useremail']);
        $password     = cleanInput($_POST['password']);
        #Image Data . . . 
        $userImage      = $_FILES['userImage'];
        $userImageName   = $userImage['name'];
        $userImageType   = $userImage['type'];
        $userImageSize   = $userImage['size'];
        $userImageTmp    = $userImage['tmp_name'];
        $finalImageName  = "";

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
        null
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
        if(!Validate($password, "required"))
        {
            $errors["Password"] ="Password  Is Required ";
        }
        elseif(!Validate($password, "password"))
        {
            $errors["Password"] ="Password  Is Not Correct ";
        }
        else
        {
            $passwordHashed = hashPasswords($password);
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
        if(!Validate($userImageName, "required"))
        {
            $errors["userImage"] ="Image Is Required ";
        }
        elseif(!Validate($userImageType, "fileExtension",null,['png', 'jpg', 'jpeg', 'webp']))
        {
            $errors["userImage"] ="Image Type Is Not Correct ";
        }
        elseif(!Validate($userImageSize, "fileSize",null,null,716800))
        {

            $errors["userImage"] ="Image Must Be Not Greater Than 600 KB ";
        }

        if(empty($errors))
        {
            $checkUpload =UploadFile($userImageType,$userImageTmp,"../uploads/users/");
            if($checkUpload)
            {
                $finalImageName = $checkUpload ;
            }
            else
            {
                $errors["userImage"] ="Something Went Wrong In Image Upload ";
            }
            // Check After Check Upload 
            if(empty($errors))
            {
                $tableName = "users";
                $dataInputs = array(
                    "user_name"  => $name,
                    "email"      => $email,
                    "password"   => $passwordHashed,
                    "user_image" =>$finalImageName,
                    "user_group" => $usergroup
                );
                if(Insert($tableName,$dataInputs))
                {
                    $_SESSION['successMsg'] = "User Added Success";
                    header("refresh:1;url=".$_SERVER['PHP_SELF']."?action=add");
                }
                else
                {
                    $_SESSION['errors'] = "somthing Went Wrong In Added";
                    header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=add");
                }
            }
        }
    }

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
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add New User
        </header>
        <div class="panel-body">
            <form role="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=add";?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="username">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="password">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter Email" name="useremail">
                </div>

                <div class="form-group">
                    <label>Image</label>
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
                                    echo '<option value="'.$groupId.'"';;
                                    echo '>'.$groupName.'</option>';
                                } 
                            ?>
                    </select> 
                </div>


                <input type="submit" class="btn btn-success" value="Add User" name="adduser">
            </form>

        </div>
    </section>
</div>