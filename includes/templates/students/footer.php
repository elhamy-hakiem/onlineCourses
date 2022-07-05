
    <!--footer start-->
    <footer class="footer navbar-fixed-bottom" style="padding-top:17px ;">
        <div class="text-center">
            2022 &copy; EDUSITE By ElHAMY ABDELHAKIEM.
            <a href="#" class="go-top">
                <i class="icon-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../assets/front/js/jquery.js"></script>
    <script src="../assets/front/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/front/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/front/js/hover-dropdown.js"></script>
    <script defer src="js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="../assets/front/assets/bxslider/jquery.bxslider.js"></script>

    <script type="text/javascript" src="../assets/front/js/jquery.parallax-1.1.3.js"></script>
    <script src="../assets/front/js/jquery.easing.min.js"></script>
    <script src="../assets/front/js/link-hover.js"></script>

    <script src="../assets/front/assets/fancybox/source/jquery.fancybox.pack.js"></script>

    <script type="text/javascript" src="../assets/front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="../assets/front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <!--common script for all pages-->
    <script src="../assets/front/js/common-scripts.js"></script>

    <script src="../assets/front/js/revulation-slide.js"></script>


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
