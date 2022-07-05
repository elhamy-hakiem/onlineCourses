<?php
require  "../globals.php";
$pageTitle="EDUSITE Control Panel"; 
include INCLUDES."/templates/admin/header.php";
include INCLUDES."/templates/admin/sidebar.php";
if(!checkLogin())
{
    header("location:login.php");
}
else
{
    if($_SESSION['user']['user_group'] == 1 || $_SESSION['user']['user_group'] == 2)
    {
?>
        <!--state overview start-->
        <div class="row state-overview">
            
            <!-- Total Admins  -->
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <h1>
                            <?php 
                                if(!empty(getUsersByGroup(2)))
                                    echo count(getUsersByGroup(2));
                                else
                                    echo 0;
                            ?>
                        </h1>
                        <p><strong>Admins</strong></p>
                    </div>
                </section>
            </div>

            <!-- Total Instructors  -->
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol orange">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <h1>
                            <?php
                                if(!empty(getUsersByGroup(3)))
                                    echo count(getUsersByGroup(3));
                                else
                                    echo 0;
                            ?>
                        </h1>
                        <p><strong>Instructors</strong></p>
                    </div>
                </section>
            </div>

            <!-- Total Students  -->
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol pink">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <h1>
                            <?php 
                                if(!empty(getUsersByGroup(4)))
                                    echo count(getUsersByGroup(4));
                                else
                                    echo 0;
                            ?>
                        </h1>
                        <p><strong>Students</strong></p>
                    </div>
                </section>
            </div>

            <!-- Total Categories  -->
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="icon-tags"></i>
                    </div>
                    <div class="value">
                        <h1>
                            <?php 
                                if(!empty(getAllFrom("*","course_categories")))
                                    echo count(getAllFrom("*","course_categories"));
                                else
                                    echo 0;
                            ?>
                        </h1>
                        <p>Categories</p>
                    </div>
                </section>
            </div>

            <!-- Total Courses  -->
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol yellow">
                        <i class="icon-book"></i>
                    </div>
                    <div class="value">
                        <h1>
                            <?php 
                                if(!empty(getAllFrom("*","courses")))
                                    echo count(getAllFrom("*","courses"));
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
                                if(!empty(getAllFrom("*","courses_lessons")))
                                    echo count(getAllFrom("*","courses_lessons"));
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
    else
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
}
include INCLUDES."/templates/admin/footer.php";
ob_end_flush();
?>