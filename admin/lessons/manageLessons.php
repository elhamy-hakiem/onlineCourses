<!-- page start-->
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Lessons For <strong><?php echo strtoupper($course[0]['course_title']); ?> </strong>Course 
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <table id="lessonsTable" class="table table-bordered table-striped table-condensed display">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Instructor</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty ($lessons))
                                    {
                                        foreach($lessons as $lesson)
                                        {
                                            $lessonid      = $lesson["lesson_id"];
                                            $title         = $lesson["lesson_title"];
                                            $courseid      = $lesson["lesson_course"];
                                            $course        = $lesson["course_title"];

                                            $instructorId  = $lesson["lesson_instructor"];
                                            $instructor    = $lesson["user_name"];
                                        
                                ?>
                                            <tr>
                                                <td><strong><?php echo $lessonid; ?></strong></td>
                                                <td><strong><?php echo $title; ?></strong></td>
                                                <td><strong><?php echo $course; ?></strong></td>
                                                <td><strong><a href="courses.php?action=manage&uid=<?php echo $instructorId; ?>"><i class="icon-user"></i> <?php echo $instructor; ?></a></strong></td>

                                                <td>
                                                    <a href="courselessons.php?action=delete&courseid=<?php echo $courseid; ?>&lessonid=<?php echo $lessonid; ?>" type="button" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                <?php  }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="5">No Course Lessons Found</td></tr>';
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