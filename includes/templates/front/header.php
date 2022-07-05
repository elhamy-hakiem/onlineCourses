<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="assets/front/img/banner/imac.png">

    <title>EduSite | <?php getTitle();?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/front/css/theme.css" rel="stylesheet">
    <link href="assets/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/front/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/front/css/flexslider.css"/>
    <link href="assets/front/assets/bxslider/jquery.bxslider.css" rel="stylesheet" />
    <link href="assets/front/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/front/assets/revolution_slider/css/rs-style.css" media="screen">
    <link rel="stylesheet" href="assets/front/assets/revolution_slider/rs-plugin/css/settings.css" media="screen">

    <!-- Custom styles for this template -->
    <link href="assets/front/css/style.css" rel="stylesheet">
    <link href="assets/front/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--header start-->
    <header class="header-frontend">
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Edu<span>Site</span></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li <?php pageActive("home"); ?>><a href="index.php">Home</a></li>
                        <li <?php pageActive("courses"); ?>><a href="courses.php">Courses</a></li>
                        <li <?php pageActive("about"); ?>><a href="about.php">About</a></li>
                        <?php if(!checkLogin()){?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        <?php }
                            else
                            {
                                echo '<li><a href="student/index.php">Go Profile</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--header end-->