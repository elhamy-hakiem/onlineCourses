<div class="row">
    <div class="col-lg-12">
        <!--widget start-->
        <aside class="profile-nav alt green-border">
            <section class="panel">
                <div class="user-heading alt course-bg course-alt">
                    <!-- Start Set Cover Image  -->
                    <input id="courseCoverHidden" type="hidden" 
                    value="<?php 
                                if(!empty($courseData[0]['course_cover']) && file_exists(UPLOADS."/courses/".$courseData[0]['course_cover']))
                                { echo $courseData[0]['course_cover'];}
                                else{echo "default.jpg" ;} 
                            ?>">
                    <!-- End Set Cover Image  -->
                    <h1 class="course-header"><strong><?php echo $courseData[0]['course_title'];?></strong></h1>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <a>
                            <strong class="text-primary">Course Description : </strong>
                            <p>
                                <?php echo $courseData[0]['course_description'];?>
                            </p>
                        </a>
                    </li>
                    <li><a href="courselessons.php?action=manage&courseid=<?php echo $courseData[0]['course_id'];?>"> <i class="icon-expand"></i> Total Lessons <span class="label label-danger pull-right r-activity"><?php echo  $numCourseLessons; ?></span></a></li>
                    <li><a href="coursestudents.php?action=manage&courseid=<?php echo $courseData[0]['course_id'];?>"> <i class="icon-user"></i> Total Students <span class="label label-warning  pull-right r-activity"><?php echo  $numCourseStudents; ?></span></a></li>
                    <li><a href="coursestudents.php?action=manage&courseid=<?php echo $courseData[0]['course_id'];?>&approve=0"> <i class="icon-user"></i> Students Waiting Approved <span class="label label-success  pull-right r-activity"><?php echo  $numStudentsWaitingApproved; ?></span></a></li>
                </ul>

            </section>
        </aside>
        <!--widget end-->
</div>