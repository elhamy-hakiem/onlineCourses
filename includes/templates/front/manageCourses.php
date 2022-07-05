
    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1><?php getTitle();?></h1>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="row">
                            <div class="col-lg-8 col-sm-8">
                                <input type="search" name="searchInp" class="form-control" placeholder="search course">
                            </div>
                            <div class="col-lg-4 col-sm-4" style="padding-left: 0px;">
                                <input type="submit" name="searchCourse" value="search" class="btn" style="background: #F77B6F;color: #fff;">
                            </div>
                        </div>
                    </form>
                    <?php
                        // Start Show Errors 
                        if(!empty($errors))
                        {
                            foreach($errors as $key => $error)
                            {
                                echo '<span class="text-danger">'.$error.'</span><br>';
                            }
                        }
                    ?>
                </div>

                <div class="col-lg-4 col-sm-4">
                    <ol class="breadcrumb pull-right">
                        <li><a href="#">Home</a></li>
                        <li class="active"><?php getTitle();?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->

    <!--container start-->
    <div class="container">
        <div class="gallery-container">
            <ul id="filters" class="list-unstyled">
                <li><a href="courses.php?action=manage" data-filter="*"> All</a></li>
                <?php 
                    if(!empty($categories))
                    {
                        foreach($categories as $category)
                        {  
                            $catId = $category['category_id'];
                            $catName = $category['category_name'];
                            echo "<li><a href='courses.php?action=manage&cid=".$catId."'>$catName</a></li>";

                        }
                    }
                ?>
            </ul>
            <!-- Start Show Courses  -->
            <div id="gallery" class="col-4">            
                <?php 
                    if(!empty($courses))
                    {
                        foreach($courses as $course)
                        {  
                            $courseId    = $course['course_id'];
                            $courseTitle = $course['course_title'];
                            $courseCover = $course['course_cover'];
                            $courseCat   = $course['course_category'];
                ?>

                            <div class="element item view view-tenth" data-zlname="reverse-effect">
                                <img src="<?php echo './uploads/courses/'.$courseCover;?>" alt="" />
                                <div class="mask">
                                    <h2><?php echo $courseTitle;?></h2>
                                    <a data-zl-popup="link" href="coursedetails.php?courseid=<?php echo $courseId ;?>">
                                        <i class="icon-link"></i>
                                    </a>
                                    <a data-zl-popup="link2" class="fancybox" rel="group" href="<?php echo './uploads/courses/'.$courseCover;?>">
                                        <i class="icon-search"></i>
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

