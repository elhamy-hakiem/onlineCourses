<?php
require  "./globals.php";
$pageTitle="Home";
$pageActive ="home"; 
include INCLUDES."/templates/front/header.php";
?>
    <!-- revolution slider start -->
    <div class="fullwidthbanner-container main-slider">
        <div class="fullwidthabnner">
            <ul id="revolutionul" style="display:none;">
                <!-- 1st slide -->
                <li data-transition="fade" data-slotamount="8" data-masterspeed="700" data-delay="9400" data-thumb="">
                    <div class="caption lfl slide_item_left"
                        data-x="10"
                        data-y="70"
                        data-speed="400"
                        data-start="1500"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/ban2.png" alt="Image 1">
                    </div>
                    <div class="caption lfr slide_title"
                        data-x="670"
                        data-y="120"
                        data-speed="400"
                        data-start="1000"
                        data-easing="easeOutExpo">
                        A Leading Online Courses
                    </div>

                    <div class="caption lfr slide_subtitle dark-text"
                        data-x="670"
                        data-y="190"
                        data-speed="400"
                        data-start="2000"
                        data-easing="easeOutExpo">
                        The Most Trusted Online Courses
                    </div>
                    <div class="caption lfr slide_desc"
                        data-x="670"
                        data-y="260"
                        data-speed="400"
                        data-start="2500"
                        data-easing="easeOutExpo">
                        Online courses System is an application designed and  <br>
                        developed for students and instructors,<br>
                        The system helps students to take Courses online.
                    </div>
                </li>

                <!-- 2nd slide  -->
                <li data-transition="fade" data-slotamount="8" data-masterspeed="700" data-delay="9400" data-thumb="">
                    <!-- THE MAIN IMAGE IN THE FIRST SLIDE -->
                    <img src="assets/front/img/banner/banner_bg.jpg" alt="">
                    <div class="caption lft slide_title"
                        data-x="10"
                        data-y="125"
                        data-speed="400"
                        data-start="1500"
                        data-easing="easeOutExpo">
                        Flexible Application
                    </div>
                    <div class="caption lft slide_subtitle dark-text"
                        data-x="10"
                        data-y="180"
                        data-speed="400"
                        data-start="2000"
                        data-easing="easeOutExpo">
                        Scope of this project is very wide
                    </div>
                    <div class="caption lft slide_desc dark-text"
                        data-x="10"
                        data-y="240"
                        data-speed="400"
                        data-start="2500"
                        data-easing="easeOutExpo">
                        It can be used anyplace <br>
                        any time as it web base application,<br>
                        eaque ipsa quae ablic jiener.
                    </div>
                    <div class="caption lft start"
                        data-x="640"
                        data-y="55"
                        data-speed="400"
                        data-start="2000"
                        data-easing="easeOutBack"  >
                        <img src="assets/front/img/banner/man.png" alt="man">
                    </div>
                    <div class="caption lft slide_item_right"
                        data-x="330"
                        data-y="20"
                        data-speed="500"
                        data-start="5000"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/test_man.png" id="rev-hint2" alt="txt img">
                    </div>

                </li>

                <!-- 3rd slide  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="300" data-delay="9400" data-thumb="">
                    <img src="assets/front/img/banner/red-bg.jpg" alt="">
                    <div class="caption lfl slide_item_right"
                        data-x="10"
                        data-y="105"
                        data-speed="1200"
                        data-start="1500"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/imac.png" alt="Image 1">
                    </div>
                    <div class="caption lfl slide_item_right"
                        data-x="25"
                        data-y="345"
                        data-speed="1200"
                        data-start="2000"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/tab.png" alt="Image 1">
                    </div>
                    <div class="caption lfl slide_item_right"
                        data-x="200"
                        data-y="330"
                        data-speed="1200"
                        data-start="2500"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/mobile.png" alt="Image 1">
                    </div>
                    <div class="caption lfl slide_item_right"
                        data-x="250"
                        data-y="230"
                        data-speed="1200"
                        data-start="3000"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/laptop.png" alt="Image 1">
                    </div>
                    <div class="caption lfl slide_item_right"
                        data-x="165"
                        data-y="30"
                        data-speed="500"
                        data-start="5000"
                        data-easing="easeOutBack">
                        <img src="assets/front/img/banner/text_imac.png" id="rev-hint1" alt="Image 1">
                    </div>

                    <div class="caption lfr slide_title slide_item_left yellow-txt"
                        data-x="670"
                        data-y="145"
                        data-speed="400"
                        data-start="3500"
                        data-easing="easeOutExpo">
                        Full Responsive
                    </div>
                    <div class="caption lfr slide_subtitle slide_item_left"
                        data-x="670"
                        data-y="200"
                        data-speed="400"
                        data-start="4000"
                        data-easing="easeOutExpo">
                        And Awesome Flat Design
                    </div>
                </li>

            </ul>
        <div class="tp-bannertimer tp-top"></div>
        </div>
    </div>
    <!-- revolution slider end -->



    <!--container start-->
    <div class="container">
        <div class="row">
            <!--feature start-->
            <div class="text-center feature-head">
                <h1>welcome to EduSite</h1>
                <p>The Most Trusted Online Courses Platform</p>
            </div>
            <div class="col-lg-4 col-sm-4">
                <section>
                    <div class="f-box">
                        <i class=" icon-desktop"></i>
                        <h2>friendly interface</h2>
                    </div>
                    <p class="f-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ablic jiener.</p>
                </section>
            </div>
            <div class="col-lg-4 col-sm-4">
                <section>
                    <div class="f-box active">
                        <i class=" icon-code"></i>
                        <h2>Join Courses</h2>
                    </div>
                    <p class="f-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ablic jiener.</p>
                </section>
            </div>
            <div class="col-lg-4 col-sm-4">
                <section>
                    <div class="f-box">
                        <i class="icon-gears"></i>
                        <h2>fully customizable</h2>
                    </div>
                    <p class="f-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ablic jiener.</p>
                </section>
            </div>
            <!--feature end-->
        </div>
    </div>

    <div class="container">
        <!--recent work start-->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="r-work">Recent Courses</h2>
                <ul class="bxslider">
                    <?php 
                        $courses = getLatest( "*" ,"courses" ,"course_id" , 4);
                        if(!empty($courses))
                        {
                            foreach($courses as $course)
                            {
                    ?>
                                <li>
                                    <div class="element item view view-tenth" data-zlname="reverse-effect">
                                        <img src="./uploads/courses/<?php echo $course['course_cover']; ?>" alt="" />
                                        <div class="mask">
                                            <a data-zl-popup="link" href="coursedetails.php?courseid=<?php echo $course['course_id']; ?>">
                                                <i class="icon-link"></i>
                                            </a>
                                            <a data-zl-popup="link2" class="fancybox" rel="group" href="./uploads/courses/<?php echo $course['course_cover']; ?>">
                                                <i class="icon-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                    <?php
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <!--recent work end-->

    </div>
    <!--container end-->
<?php
    include INCLUDES."/templates/front/footer.php";
    ob_end_flush();
?>