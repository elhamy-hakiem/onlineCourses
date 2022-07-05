    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-4">
                    <h1><?php echo $lessons[0]['course_title'] ?> Course</h1>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <ol class="breadcrumb pull-right">
                        <li><a href="#">Home</a></li>
                        <li class="active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->
    
    <!--container start-->
    <div class="container">
        <div class="gallery-container">
            <!-- Start Show Courses  -->
            <div id="gallery" class="col-4">            
                <?php 
                    if(!empty($lessons))
                    {
                        foreach($lessons as $lesson)
                        {  
                            $lessonId      = $lesson["lesson_id"];
                            $lessoncover   = $lesson["lesson_cover"];
                            $lessonTitle   = $lesson["lesson_title"];

                            $courseId      = $lesson["lesson_course"];
                ?>

                            <div class="element item view view-tenth" data-zlname="reverse-effect">
                                <?php
                                    if(!empty($lessoncover) && file_exists(UPLOADS."/lessons/".$lessoncover))
                                    {
                                ?>
                                        <img src='<?php echo "../uploads/lessons/$lessoncover" ;?>' alt ='Lesson cover'/>
                                <?php 
                                    }
                                    else
                                    {
                                ?>
                                        <img src='<?php echo "../uploads/lessons/default.jpg" ;?>' alt ='Lesson cover'/>
                                <?php 
                                    }
                                ?>
                                <div class="mask">
                                    <h2><?php echo $lessonTitle;?></h2>
                                    <a data-zl-popup="link" href="lessondetails.php?courseid=<?php echo $courseId ;?>&lessonid=<?php echo $lessonId ;?>">
                                        <i class="icon-link"></i>
                                    </a>
                                </div>
                            </div>
                <?php            
                        }
                    }
                ?>
            </div>
            <!-- End Show Courses  -->
        </div>
    </div>
    <!--container end-->

