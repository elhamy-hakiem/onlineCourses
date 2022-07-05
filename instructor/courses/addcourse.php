<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addcourse']))
    {
        $title         = cleanInput($_POST['title']);
        $description   = cleanInput($_POST['description']);
        #Image Data . . . 
        $CourseCover       = $_FILES['CourseCover'];
        $CourseCoverName   = $CourseCover['name'];
        $CourseCoverType   = $CourseCover['type'];
        $CourseCoverSize   = $CourseCover['size'];
        $CourseCoverTmp    = $CourseCover['tmp_name'];
        $finalCoverName    = "";

        #Category Data . . . 
        $courseCategory = (isset($_POST["courseCategory"]) && !empty($_POST["courseCategory"])) ? intval($_POST["courseCategory"]): 0;

        #Errors Array
        $errors = [];

        #Validate Title . . . . 
        if(!Validate($title, "required"))
        {
            $errors["Title"] ="title Is Required ";
        }
        elseif(!Validate($title, "min",3))
        {
            $errors["Title"] ="title Min length 3 Char ";
        }
        elseif(!Validate($title, "string"))
        {
            $errors["Title"] ="title Must Be String ";
        }

        #Validate Description . . . . 
        if(!Validate($description, "required"))
        {
            $errors["Description"] ="description Is Required ";
        }
        elseif(!Validate($description, "min",15))
        {
            $errors["Description"] ="description Min length 15 Char ";
        }
        elseif(!Validate($description, "string"))
        {
            $errors["Description"] ="description Must Be String ";
        }


        #Validate courseCategory . . . . 
        if(!Validate($courseCategory, "required"))
        {
            $errors["Category"] ="Category Is Required ";
        }
        elseif(!Validate($courseCategory, "int"))
        {
            $errors["Category"] ="Category Must Be Integer ";
        }

        #Validate Course Image . . . . 
        if(!Validate($CourseCoverName, "required"))
        {
            $errors["CourseCover"] ="Image Is Required ";
        }
        elseif(!Validate($CourseCoverType, "fileExtension",null,['png', 'jpg', 'jpeg', 'webp']))
        {
            $errors["CourseCover"] ="Image Type Is Not Correct ";
        }
        elseif(!Validate($CourseCoverSize, "fileSize",null,null,716800))
        {

            $errors["CourseCover"] ="Image Must Be Not Greater Than 600 KB ";
        }

        if(empty($errors))
        {
            $checkUpload =UploadFile($CourseCoverType,$CourseCoverTmp,"../uploads/courses/");
            if($checkUpload)
            {
                $finalCoverName = $checkUpload ;
            }
            else
            {
                $errors["CourseCover"] ="Something Went Wrong In Image Upload ";
            }
            // Check After Check Upload 
            if(empty($errors))
            {
                $tableName = "courses";
                $dataInputs = array(
                    "course_title"         => $title,
                    "course_description"   => $description,
                    "course_cover"         => $finalCoverName,
                    "course_instructor"    => $_SESSION['user']['user_id'],
                    "course_category"     => $courseCategory
                );
                if(Insert($tableName,$dataInputs))
                {
                    $_SESSION['successMsg'] = "Course Added Success";
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
<!-- Start Add Course Design  -->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add New Course
        </header>
        <div class="panel-body">
            <form role="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=add";?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Course Name">
                </div>

                <div class="form-group">
                    <label>Course Description</label>
                    <textarea class="form-control" name="description" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label>Cover</label>
                    <input type="file" class="form-control" name="CourseCover">
                </div>

                <div class="form-group">
                    <label>Course Category</label>
                    <select name="courseCategory"  class="form-control">
                        <option value="0" >choose Course Category</option>
                        <?php
                            $categories = getAllFrom(
                                "*" ,
                                "course_categories",
                                "",
                                "",
                                "",
                                null
                            );
                            foreach($categories as $category)
                            {
                                $categoryId   = $category['category_id'];
                                $CateoryName  = $category['category_name'];
                                echo '<option value="'.$categoryId.'">'.$CateoryName.'</option>';
                            } 
                        ?>
                    </select> 
                </div>


                <input type="submit" class="btn btn-success" value="Add Course" name="addcourse">
            </form>

        </div>
    </section>
</div>
<!-- End Add Course Design  -->