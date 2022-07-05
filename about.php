<?php
require  "./globals.php";
$pageTitle="About";
$pageActive ="about"; 
include INCLUDES."/templates/front/header.php";
?>
    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1><?php getTitle();?> US</h1>
                </div>
                <div class="col-lg-8 col-sm-8">
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
        <div class="row">
            <div class="col-lg-10 about">
                <h3>Welcome to Edusite</h3>
                <p>
                    The Most Trusted Online Courses Platform
                    Edusite System is an application designed and developed for students and instructors.<br>
                    The system helps students to take Courses online. It also helps instructors to make Courses for students 
                </p>
                <p>
                    Edusite System provides various features which make it a user friendly interface, its the best platform to Watch  online Courses
                </p>
            </div>
        </div>
    </div>

    <!-- Start Show My Skills  -->
    <div class="gray-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="skills">Our Crazy Skills</h3>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 70%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">Web Design : 70% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 90%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">Html/CSS : 90% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 85%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">PHP : 85% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 85%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">OOP : 85% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 85%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">MVC : 85% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-skill-meter">
                        <div class="progress progress-xs">
                            <div style="width: 75%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">Laravel FrameWork : 75% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Show My Skills  -->

    <div class="container">
        <div class="row">
            <div class="text-center feature-head">
                <h1> Meet Me </h1>
                <p>I work with forward thinking clients to create beautiful, honest and amazing things that bring positive results.</p>
            </div>
            <div class="col-lg-12">
                <div class="person text-center">
                    <img src="./uploads/team/elhamy.jpg" alt="">
                </div>
                <div class="person-info text-center">
                    <h4>
                        <a href="javascript:;">Elhamy Abdelhakiem</a>
                    </h4>
                    <p class="text-muted"> Backend Developer </p>
                    <div class="team-social-link">
                        <a href="https://github.com/elhamy-hakiem"><i class="icon-github"></i></a>
                        <a href="https://www.linkedin.com/in/elhamy-abdelhakiem-95ab51192/"><i class="icon-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--container end-->

<?php
    include INCLUDES."/templates/front/footer.php";
    ob_end_flush();
?>