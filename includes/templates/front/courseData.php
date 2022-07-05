    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1><?php echo $course[0]['course_title']; ?></h1>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="#">Home</a></li>
                        <li class="active"><?php echo $course[0]['course_title']; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->

    <!--container start-->
    <div class="container">
        <div class="row">
            <!--blog start-->
            <div class="col-lg-9 ">
                <?php
                    if(!empty($course))
                    {
                        $courseId           = $course[0]['course_id'];
                        $courseTitle        = $course[0]['course_title'];
                        $courseCover        = $course[0]['course_cover'];
                        $courseDesciption   = $course[0]['course_description'];
                        $courseInstructor   = $course[0]['user_name'];

                        $lessons = getAllFrom
                                            (
                                                "*" ,
                                                "courses_lessons",
                                                "WHERE `lesson_course` = $courseId",
                                            );
                ?>
                        <div class="blog-item">
                            <div class="row">
                                <div class="col-lg-2 col-sm-2">
                                    <div class="date-wrap">
                                        <span class="date">
                                            <?php
                                            if(!empty($lessons))
                                                echo count($lessons);
                                            else
                                                echo 0;
                                            ?>
                                        </span>
                                        <span class="month">Lessons</span>
                                    </div>

                                    <div class="date-wrap">
                                        <span class="date">
                                            BY
                                        </span>
                                        <span class="month"><?php echo $courseInstructor; ?></span>
                                    </div>

                                </div>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="blog-img">
                                        <img src="./uploads/courses/<?php echo $courseCover; ?>" alt=""/>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 text-center">
                                    <h1><a href="blog_detail.html"><?php echo $courseTitle; ?></a></h1>
                                    <p><?php echo $courseDesciption; ?></p>
                                        <?php
                                        if(!checkLogin())
                                        {
                                            echo "<h4> You Must ";
                                                echo '<a href="login.php" class="text-danger">Login</a>';
                                            echo " As Student To Join This Course </h3> ";
                                        }
                                        else
                                        {
                                            $studentId = $_SESSION['user']['user_id'];
                                            if(isStudentJoinedCourse($studentId,$courseId))
                                            {
                                                if(isApprovedJoinedCourse($studentId,$courseId))
                                                    echo '<a href="student/courseLessons.php?courseid='.$courseId.'" class="btn btn-danger">View Course</a>';
                                                else
                                                    echo '<a href="courses.php?action=delete&courseid='.$courseId.'" class="btn btn-danger">Waiting Approve</a>';
                                                
                                            }
                                            else
                                            {
                                                echo '<a href="courses.php?action=join&courseid='.$courseId.'" class="btn btn-danger">Join Course</a>';
                                            }
                                        }
                                        // Show Message 
                                        echo getErrors();
                                        echo getSuccessMsg();
                                        ?>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>

            <div class="col-lg-3">
                <div class="blog-side-item">
                    <!-- Start Show Latest Categories  -->
                    <div class="category">
                        <h3>Categories</h3>
                        <ul class="list-unstyled">
                            <?php 
                                #Get All Categories From DataBase . . . 
                                $categories =getAllFrom
                                (
                                    "*" ,
                                    "course_categories",
                                    "",
                                    "",
                                    "ORDER BY `category_id` DESC",
                                    "LIMIT 4"
                                );
                                if(!empty($categories))
                                {
                                    foreach($categories as $category)
                                    {
                            ?>
                                        <li><a href="courses.php?action=manage&cid=<?php echo $category['category_id'];?>"><i class="  icon-angle-right"></i> <?php echo $category['category_name'];?></a></li>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <!-- End Show Latest Categories  -->

                    <!-- Start Show Latest Courses  -->
                    <div class="blog-post">
                        <h3>Latest Course Post</h3>
                    <?php
                        $courses = getAllFrom
                        (
                            "*" ,
                            "courses",
                            "",
                            "ORDER BY `course_id` DESC",
                            "LIMIT 4",
                            null
                        );
                        if(!empty($courses))
                        {
                            foreach($courses as $course)
                            {
                    ?>
                                <div class="media">
                                    <a class="pull-left" href="coursedetails.php?courseid=<?php echo $course['course_id'];?>">
                                        <img style="width: ;50px;height:70px;" class="" src="./uploads/courses/<?php echo $course['course_cover'];?>" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="javascript:;"><strong><?php echo $course['course_title'];?></strong></a></h5>
                                        <p>
                                            <?php echo $course['course_description'];?>
                                        </p>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    ?>

                    </div>
                    <!-- End Show Latest Courses  -->

                </div>
            </div>

            <!--blog end-->
        </div>

    </div>
    <!--container end-->