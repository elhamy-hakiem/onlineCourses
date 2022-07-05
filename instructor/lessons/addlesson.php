<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addLesson']))
    {
        $title         = cleanInput($_POST['lessonTitle']);
        $description   = cleanInput($_POST['lessonDescription']);
        #Image Data . . . 
        $lessonCover       = $_FILES['lessonCover'];
        $lessonCoverName   = $lessonCover['name'];
        $lessonCoverType   = $lessonCover['type'];
        $lessonCoverSize   = $lessonCover['size'];
        $lessonCoverTmp    = $lessonCover['tmp_name'];
        $finalCoverName    = "";

        #Video Data . . . 
        $lessonVideo       = $_FILES['lessonVideo'];
        $lessonVideoName   = $lessonVideo['name'];
        $lessonVideoType   = $lessonVideo['type'];
        $lessonVideoSize   = $lessonVideo['size'];
        $lessonVideoTmp    = $lessonVideo['tmp_name'];
        $finalVideoName    = "";
        
        #Errors Array
        $errors = [];

        #Check Lesson Name . . . 
        $lessonData = getAllFrom
                                    (
                                        "*" ,
                                        "courses_lessons",
                                        "",
                                        "",
                                        "WHERE  `lesson_title` = '$title'",
                                        "AND `lesson_course` = $courseId LIMIT 1"
                                    );
        #Validate Title . . . . 
        if(!Validate($title, "required"))
        {
            $errors["Title"] ="title Is Required ";
        }
        elseif(!empty($lessonData))
        {
            $errors["Title"] ="Lesson title Is Already Exist ";
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


        #Validate Lesson Image . . . . 
        if(!Validate($lessonCoverName, "required"))
        {
            $errors["lessonCover"] ="Image Is Required ";
        }
        elseif(!Validate($lessonCoverType, "fileExtension",null,['png', 'jpg', 'jpeg', 'webp']))
        {
            $errors["lessonCover"] ="Image Type Is Not Correct ";
        }
        elseif(!Validate($lessonCoverSize, "fileSize",null,null,716800))
        {

            $errors["lessonCover"] ="Image Must Be Not Greater Than 600 KB ";
        }

        #Validate Lesson Video . . . . 
        if(!Validate($lessonVideoName, "required"))
        {
            $errors["lessonVideo"] ="Video Is Required ";
        }
        elseif(!Validate($lessonVideoType, "fileExtension",null,['webm','mkv','mp4','Ogg']))
        {
            $errors["lessonVideo"] ="Video Type Is Not Correct ";
        }
        elseif(!Validate($lessonVideoSize, "fileSize",null,null,4096000))
        {

            $errors["lessonVideo"] ="Video Must Be Not Greater Than 4 MB ";
        }

        if(empty($errors))
        {
            $checkUpload =UploadFile($lessonCoverType,$lessonCoverTmp,"../uploads/lessons/");
            if($checkUpload)
            {
                $finalCoverName = $checkUpload ;
            }
            else
            {
                $errors["lessonCover"] ="Something Went Wrong In Image Upload ";
            }

            $checkUploadVideo =UploadFile($lessonVideoType,$lessonVideoTmp,"../uploads/videos/");
            if($checkUploadVideo)
            {
                $finalVideoName = $checkUploadVideo ;
            }
            else
            {
                $errors["lessonVideo"] ="Something Went Wrong In Video Upload ";
            }
            // Check After Check Upload 
            if(empty($errors))
            {
                $tableName = "courses_lessons";
                $dataInputs = array(
                    "lesson_title"         => $title,
                    "lesson_description"   => $description,
                    "lesson_cover"         => $finalCoverName,
                    "lesson_video"         => $finalVideoName,
                    "lesson_instructor"    => $_SESSION['user']['user_id'],
                    "lesson_course"        => $courseId
                );
                if(Insert($tableName,$dataInputs))
                {
                    $_SESSION['successMsg'] = "Lesson Added Success";
                    header("refresh:1;url=".$_SERVER['PHP_SELF']."?action=add&courseid=$courseId");
                }
                else
                {
                    $_SESSION['errors'] = "somthing Went Wrong In Added";
                    header("refresh:2;url=".$_SERVER['PHP_SELF']."?action=add&courseid=$courseId");
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

<!-- Start Add Lesson Design  -->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add New Lesson
        </header>
        <div class="panel-body">
            <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?action=add&courseid=".$courseId;?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Title : </label>
                    <input type="text" class="form-control" name="lessonTitle" placeholder="Enter Lesson Name">
                </div>

                <div class="form-group">
                    <label>Lesson Description : </label>
                    <textarea class="form-control" name="lessonDescription" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label>Lesson Cover : </label>
                    <input type="file" class="form-control" name="lessonCover">
                </div>

                <div class="form-group">
                    <label>Lesson Video : </label>
                    <input type="file" class="form-control" name="lessonVideo">
                </div>

                <input type="submit" class="btn btn-success" value="Add Lesson" name="addLesson">
                <a href="courselessons.php?action=manage&courseid=<?php echo $courseId;?>" class="mt-2 btn btn-primary">Back To Lessons</a>
            </form>
        </div>
    </section>
</div>
<!-- End Add Lesson Design  -->