<?php
require  "../globals.php";
$pageTitle="Instructor Control Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/instructor/sidebar.php";
if(!checkLogin())
{
    header("location:login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 3)
    {
        #Show Errors Or Success
        echo getErrors();
        echo getSuccessMsg();

        // Start define action 
        $action= isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'manage' ;
        // End define action 
        // start Update Profile 
        if($action == 'profile')
        {
            require "../admin/profile.php";
        }
        // End Update Profile 
        else
        {
?>
            <!--state overview start-->
            <div class="row state-overview">

                <!-- Total Courses  -->
                <div class="col-lg-4 col-sm-6">
                    <section class="panel">
                        <div class="symbol yellow">
                            <i class="icon-book"></i>
                        </div>
                        <div class="value">
                            <h1>
                                <?php 
                                    $instructorId = $_SESSION['user']['user_id'];
                                    if(!empty(getAllFrom("*","courses",null,null,"WHERE course_instructor = $instructorId")))
                                        echo count(getAllFrom("*","courses",null,null,"WHERE course_instructor = $instructorId"));
                                    else
                                        echo 0;
                                ?>
                            </h1>
                            <p>Courses</p>
                        </div>
                    </section>
                </div>

                <!-- Total Lessons  -->
                <div class="col-lg-4 col-sm-6">
                    <section class="panel">
                        <div class="symbol blue">
                            <i class="icon-expand"></i>
                        </div>
                        <div class="value">
                            <h1>
                                <?php 
                                    if(!empty(getAllFrom("*","courses_lessons",null,null,"WHERE lesson_instructor = $instructorId")))
                                        echo count(getAllFrom("*","courses_lessons",null,null,"WHERE lesson_instructor = $instructorId"));
                                    else
                                        echo 0;
                                ?>
                            </h1>
                            <p>Lessons</p>
                        </div>
                    </section>
                </div>
            </div>
            <!--state overview end-->
<?php
        }
    }
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>