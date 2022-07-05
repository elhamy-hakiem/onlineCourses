<?php
    if(isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['addgroup']))
    {
        $groupName  = cleanInput($_POST['groupname']);
        $errors = [];
        #Validate Group Name . . . . 
        if(!Validate($groupName, "required"))
        {
            $errors["groupName"] ="Group Name Is Required ";
        }
        elseif(!Validate($groupName, "min",4))
        {
            $errors["groupName"] ="Group Name Min length 4 Char ";
        }
        elseif(!Validate($groupName, "string"))
        {
            $errors["groupName"] ="Group Name Must Be String ";
        }
        else
        {
            $group = getAllFrom("group_name" , "users_groups",  NULL, NULL,"WHERE `group_name` = '$groupName' ", "LIMIT 1");
            if(!empty($group))
            {
                $errors["groupName"] ="Group Name Already Exist  ";
            }
            else
            {
                $tableName = "users_groups";
                $dataInputs = array(
                    "group_name"  => $groupName
                );
                if(Insert($tableName,$dataInputs))
                {
                    $_SESSION['successMsg'] = "Group Added Success";
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
            Add New Group
        </header>
        <div class="panel-body">
            <form role="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=add";?>" method="POST">
                <div class="form-group">
                    <label>Group Name</label>
                    <input type="text" class="form-control" placeholder="Enter Group Name" name="groupname">
                </div>
                <input type="submit" class="btn btn-success" value="Add Group" name="addgroup">
            </form>

        </div>
    </section>
</div>