
    <!--footer start-->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <h1>contact info</h1>
                    <address>
                        <p>Address: 6th October City</p>
                        <p>Phone : (123) 456-7890</p>
                        <p>Email : <a href="javascript:;">elhamy.hakiem@gmail.com</a></p>
                    </address>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <h1>latest tweet</h1>
                    <div class="tweet-box">
                        <i class="icon-twitter"></i>
                        <em>Please follow <a href="javascript:;">@nettus</a> for all future updates of us! <a href="javascript:;">twitter.com/vectorlab</a></em>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-lg-offset-1">
                    <h1>stay connected</h1>
                    <ul class="social-link-footer list-unstyled">
                        <li><a href="https://www.linkedin.com/in/elhamy-abdelhakiem-95ab51192/"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://github.com/elhamy-hakiem"><i class="icon-github"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end-->

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/front/js/jquery.js"></script>
    <script src="assets/front/js/jquery-1.8.3.min.js"></script>
    <script src="assets/front/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/front/js/hover-dropdown.js"></script>
    <script defer src="js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="assets/front/assets/bxslider/jquery.bxslider.js"></script>

    <script type="text/javascript" src="assets/front/js/jquery.parallax-1.1.3.js"></script>
    <script src="assets/front/js/jquery.easing.min.js"></script>
    <script src="assets/front/js/link-hover.js"></script>

    <script src="assets/front/assets/fancybox/source/jquery.fancybox.pack.js"></script>

    <script type="text/javascript" src="assets/front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="assets/front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <!--common script for all pages-->
    <script src="assets/front/js/common-scripts.js"></script>

    <script src="assets/front/js/revulation-slide.js"></script>


    <script>

        RevSlide.initRevolutionSlider();

        $(window).load(function() {
            $('[data-zlname = reverse-effect]').mateHover({
                position: 'y-reverse',
                overlayStyle: 'rolling',
                overlayBg: '#fff',
                overlayOpacity: 0.7,
                overlayEasing: 'easeOutCirc',
                rollingPosition: 'top',
                popupEasing: 'easeOutBack',
                popup2Easing: 'easeOutBack'
            });
        });

        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                start: function(slider) {
                    $('body').removeClass('loading');
                }
            });
        });

        //    fancybox
        jQuery(".fancybox").fancybox();
        </script>

    </body>
</html>
