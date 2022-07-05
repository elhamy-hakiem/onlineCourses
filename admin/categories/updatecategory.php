<?php
    if(isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['updatecategory']))
    {
        $categoryId    = intval($_POST['catid']);
        $categoryName  = cleanInput($_POST['catname']);
        $errors = [];
        #Validate Category Name . . . . 
        if(!Validate($categoryName, "required"))
        {
            $errors["categoryName"] ="Category Name Is Required ";
        }
        elseif(!Validate($categoryName, "string"))
        {
            $errors["categoryName"] ="Category Name Must Be String ";
        }
        else
        {
            $category = getAllFrom("category_name" , "course_categories",  NULL, NULL,"WHERE `category_name` = '$categoryName'  ", "AND `category_id` != $categoryId LIMIT 1");

            if(!empty($category))
            {
                $errors["categoryName"] ="Category Name Already Exist  ";
            }
            else
            {
                $tableName = "course_categories";
                $dataInputs = array(
                    "category_name"  => $categoryName,
                    "created_by"     =>$_SESSION['user']['user_id']
                );
                if(Update($tableName,$dataInputs,"WHERE `category_id` = $categoryId"))
                {
                    $_SESSION['successMsg'] = "Category Updated Success";
                    header("refresh:1;url=".$_SERVER['PHP_SELF']."?action=update&catid=$categoryId");
                }
                else
                {
                    $_SESSION['errors'] = "No Data Changed In Update";
                    header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=update&catid=$categoryId");
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
<!-- Start Update Form Design  -->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Update Category
        </header>
        <div class="panel-body">
            <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=update&catid=".$categoryId;?>" method="POST">
                <div class="form-group">
                    <input type="hidden" name="catid" value="<?php echo $categoryData[0]['category_id'];?>">
                    <label>Category Name</label>
                    <input type="text" class="form-control" placeholder="Enter Category Name" name="catname" value="<?php echo $categoryData[0]['category_name'];?>">
                </div>
                <input type="submit" class="btn btn-success" value="Update Category" name="updatecategory">
            </form>

        </div>
    </section>
</div>
<!-- End Update Form Design  -->
