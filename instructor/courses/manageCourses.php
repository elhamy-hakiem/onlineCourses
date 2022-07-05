<!-- page start-->
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?php echo '<strong>'.$_SESSION['user']['user_name'].'</strong>'; ?> Courses
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <!-- <input style="margin-bottom: 10px; width: 200px;" type="search" class="form-control" placeholder="Search" id="searchCourse"> -->
                        <table id="coursesTable" class="table table-bordered table-striped table-condensed display">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cover</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($courses))
                                    {
                                        foreach($courses as $course)
                                        {
                                            $courseid      = $course["course_id"];
                                            $courseCover   = $course["course_cover"];
                                            $title         = $course["course_title"];
                                            $category      = $course["category_name"];
                                            $instructor    = $course["user_name"];

                                            $instructorId  = $course["course_instructor"];
                                            $categoryId    = $course["course_category"];
                                        
                                ?>
                                            <tr>
                                                <td><strong><?php echo $courseid; ?></strong></td>
                                                <td>
                                                    <?php
                                                        if(!empty($courseCover) && file_exists(UPLOADS."/courses/".$courseCover))
                                                        {
                                                    ?>
                                                            <img id="userAvatar"  src='<?php echo "../uploads/courses/$courseCover" ;?>' alt ='course cover'/>
                                                    <?php 
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                            <img id="userAvatar"  src='<?php echo "../uploads/courses/default.jpg" ;?>' alt ='course cover'/>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>
                                                <td><strong><?php echo $title; ?></strong></td>
                                                <td><strong><a href="courses.php?action=manage&cid=<?php echo $categoryId; ?>"><i class="icon-tags"></i> <?php echo $category; ?></a></strong></td>
                                                <td>
                                                    <a href="courses.php?action=view&courseid=<?php echo $courseid; ?>" type="button" class="btn btn-success" ><i class="icon-eye-open"></i> View</a>
                                                    <a href="courses.php?action=update&courseid=<?php echo $courseid; ?>" type="button" class="btn btn-info" id="deleteBtn"><i class="icon-refresh"></i> Update</a>
                                                    <a href="courses.php?action=delete&courseid=<?php echo $courseid; ?>" type="button" class="btn btn-danger" id="deleteBtn"><i class="icon-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                <?php  }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="5">No Courses Found</td></tr>';
                                    }
                                ?>
                            </tbody>
                    </table>
                    </section>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->