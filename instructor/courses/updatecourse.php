<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updatecourse']))
    {
        $courseId      = intval($_POST['courseId']);
        $title         = cleanInput($_POST['title']);
        $description   = cleanInput($_POST['description']);

        #Image Data . . . 
        $CourseCover       = $_FILES['CourseCover'];
        $CourseCoverName   = $CourseCover['name'];
        $CourseCoverType   = $CourseCover['type'];
        $CourseCoverSize   = $CourseCover['size'];
        $CourseCoverTmp    = $CourseCover['tmp_name'];

        $oldCover          =  $_POST['oldcover']; 
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
        if(Validate($CourseCoverName, "required"))
        {
            if(!Validate($CourseCoverType, "fileExtension",null,['png', 'jpg', 'jpeg', 'webp']))
            {
                $errors["CourseCover"] ="Image Type Is Not Correct ";
            }
            elseif(!Validate($CourseCoverSize, "fileSize",null,null,716800))
            {
    
                $errors["CourseCover"] ="Image Must Be Not Greater Than 600 KB ";
            }
            else
            {
                if(!empty($oldCover))
                {
                    RemoveFile($oldCover,"../uploads/courses/");
                }
            }
        }
        else
        {
            if(empty($oldCover))
            {
                $errors["CourseCover"] ="Image Is Required ";
            }
            else
            {
                $finalCoverName = $oldCover;
            }
        }

        if(empty($errors))
        {
            if(empty($finalCoverName))
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
            }

            $tableName = "courses";
            $dataInputs = array(
                "course_title"         => $title,
                "course_description"   => $description,
                "course_cover"         => $finalCoverName,
                "course_instructor"    => $_SESSION['user']['user_id'],
                "course_category"     => $courseCategory
            );
            if(Update($tableName,$dataInputs,"WHERE `course_id` = $courseId"))
            {
                $_SESSION['successMsg'] = "Course Updated Success";
                header("refresh:1;url=".$_SERVER['PHP_SELF']."?action=update&courseid=$courseId");
            }
            else
            {
                $_SESSION['errors'] = "No Data Changed In Update";
                header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=update&courseid=$courseId");
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

<!-- Start Update Course Design  -->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Update Course
        </header>
        <div class="panel-body">
            <form role="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=update&courseid=".$courseId;?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="courseId" value="<?php echo $courseData[0]['course_id']?>">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Course Name" value="<?php echo $courseData[0]['course_title']?>">
                </div>

                <div class="form-group">
                    <label>Course Description</label>
                    <textarea class="form-control" name="description" rows="10"><?php echo $courseData[0]['course_description']?></textarea>
                </div>

                <div class="form-group">
                    <label>Cover</label>
                    <input type="hidden" name="oldcover" value="<?php echo $courseData[0]['course_cover']?>">
                    <input type="file" class="form-control" name="CourseCover">
                </div>

                <div class="form-group">
                    <label>Course Category</label>
                    <select name="courseCategory"  class="form-control">
                        <option value="" >choose Course Category</option>
                        <?php
                            #Get All Categories From DataBase . . . 
                            $categories =getAllFrom
                            (
                                "*",
                                "course_categories",
                                "",
                                "",
                                NULL,
                                NULL
                            );
                            foreach($categories as $category)
                            {
                                $categoryId   = $category['category_id'];
                                $CateoryName  = $category['category_name'];
                                echo '<option value="'.$categoryId.'"';
                                    if($categoryId == $courseData[0]['course_category'])
                                        echo 'selected';
                                echo '>'.$CateoryName.'</option>';
                            } 
                        ?>
                    </select> 
                </div>


                <input type="submit" class="btn btn-success" value="Update Course" name="updatecourse">
            </form>

        </div>
    </section>
</div>
<!-- End Update Course Design  -->