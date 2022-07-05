<section id="main-content" style="margin:0px auto 20px;">
    <section class="wrapper" style="overflow:hidden ; margin-top: 0px;">
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <!-- Start Lesson Cover -->
                        <div class="col-md-6">
                            <div class="pro-img-details">
                                <?php
                                    $lessonCover = $lessonData[0]['lesson_cover'];
                                    if(!empty($lessonCover) && file_exists(UPLOADS."/lessons/".$lessonCover))
                                    {
                                ?>
                                        <img src='<?php echo "../uploads/lessons/$lessonCover" ;?>' alt ='Lesson Cover'/>
                                <?php 
                                    }
                                    else
                                    {
                                ?>
                                        <img src='<?php echo "../uploads/lessons/default.jpg" ;?>' alt ='Lesson Cover'/>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- End Lesson Cover -->
                        <!-- Start Lesson Data  -->
                        <div class="col-md-6">
                            <h4 class="pro-d-title">
                                <a>
                                    <?php echo $lessonData[0]['lesson_title']?>
                                </a>
                                <a href="courselessons.php?courseid=<?php echo $lessonData[0]['lesson_course'];?>" class=" pull-right">
                                    View All Lessons <i class="icon-circle-arrow-right"></i>
                                </a>
                            </h4>
                            <div class="product_meta">
                                <p>
                                    <?php echo $lessonData[0]['lesson_description']?>
                                </p>
                                <span class="tagged_as"><strong>Course Name:</strong><a> <?php echo strtoupper($lessonData[0]['course_title']) ;?></a></span>
                                <span class="tagged_as"><strong>Instructor Name:</strong><a> <?php echo strtoupper($lessonData[0]['instructor']) ;?></a></span>
                            </div>
                            <?php
                                $courseIdAction = $lessonData[0]['lesson_course'];
                                $lessonIdAction = $lessonData[0]['lesson_id'];
                            ?>
                            <form action="./lessonsComments.php?action=add&courseid=<?php echo $courseIdAction ?>&lessonid=<?php echo $lessonIdAction ?>" method="POST">
                                <label>Add Comment : </label>
                                <input name="commTitle" type="text" class="form-control" placeholder="Comment Title">
                                <textarea name="commContent" style="margin-top:10px; margin-bottom: 10px;"  id="commentInpt" rows="5" class="form-control"  placeholder="Comment Content"></textarea>
                                <input type="submit" id="AddComment" class="btn btn-success" value="Add Comment" name="addComment" >
                            </form>
                        </div>
                        <!-- End Lesson Data  -->
                    </div>
                </section>

                <!-- Start Show Videos And Comments  -->
                <section class="panel">
                    <header class="panel-heading tab-bg-dark-navy-blue" style="padding: 10px;">
                        <ul class="nav nav-tabs ">
                            <li class="active">
                                <a data-toggle="tab" href="#video">
                                    Video
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#lessonComments">
                                    <i class="icon-comment"></i> Comments
                                </a>
                            </li>
                        </ul>
                    </header>

                    <div class="panel-body">
                        <div class="tab-content tasi-tab">
                            <!-- Start Video Content  -->
                            <div id="video" class="tab-pane active">
                                <h4 class="pro-d-head">Watch Lesson</h4>
                                <video width="100%" height="400" controls>
                                    <source src="<?php echo "../uploads/videos/".$lessonData[0]['lesson_video'];?>" type="video/mp4">
                                    <source src="<?php echo "../uploads/videos/".$lessonData[0]['lesson_video'];?>" type="video/webm">
                                    <source src="<?php echo "../uploads/videos/".$lessonData[0]['lesson_video'];?>" type="video/mkv">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <!-- End Video Content  -->

                            <!-- start Comments Content  -->
                            <div id="lessonComments" class="tab-pane" style="margin-bottom: 15px;">
                                
                                <?php
                                $lessonComments = getAllFrom(
                                                                "`courses_lessons_comments`.*,`users`.`user_name`,`users`.`user_image`",
                                                                "courses_lessons_comments",
                                                                "LEFT JOIN `users`",
                                                                "ON `courses_lessons_comments`.`comment_user` = `users`.`user_id`",
                                                                "WHERE `courses_lessons_comments`.`comment_lesson` = $lessonId;"
                                                            );
                                if(!empty($lessonComments))
                                {
                                    foreach($lessonComments as $comment)
                                    {
                                        $lessonid       = $comment["comment_lesson"];
                                        $userid         = $comment["comment_user"];
                                        $userImage      = $comment["user_image"];
                                        $userName       = $comment["user_name"];
                                        $commentid      = $comment["comment_id"];
                                        $commentTitle   = $comment["comment_title"];
                                        $commentContent = $comment["comment_content"];
                                ?>
                                        <article class="media">
                                            <a class="pull-left thumb p-thumb">
                                                    <?php
                                                        if(!empty($userImage) && file_exists(UPLOADS."/users/".$userImage))
                                                        {
                                                    ?>
                                                            <img id="userAvatar"  src='<?php echo "../uploads/users/$userImage" ;?>' alt ='User Image'/>
                                                    <?php 
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                            <img id="userAvatar"  src='<?php echo "../uploads/users/default.png" ;?>' alt ='User Image'/>
                                                    <?php 
                                                        }
                                                    ?>
                                            </a>
                                            <div class="media-body">
                                                <a href="#" class="cmt-head"><?php echo $userName;  ?> .</a>
                                                <h5><i class="icon-comment"></i> <?php echo $commentTitle;  ?></h5>
                                                <p><?php echo $commentContent;  ?></p>
                                                <a href="./lessonsComments.php?action=delete&courseid=<?php echo $courseIdAction ?>&lessonid=<?php echo $lessonid ?>&comid=<?php echo $commentid ?>" class="text-danger"><i class="icon-trash"></i> Delete</a>
                                            </div>
                                        </article>
                                <?php  }
                                    }
                                    else
                                    {
                                        echo '<p>No Lessons Comments</p>';
                                    }
                                ?> 
                            </div>  
                            <!-- End Comments Content  -->
                        </div>
                    </div>
                </section>
                <!-- End Show Videos And Comments  -->
            </div>
        </div>
    </section>
</section>