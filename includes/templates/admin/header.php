<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="EDUSITE, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="../assets/back/img/mooclogo.jpg">

    <title><?php getTitle();?></title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/back/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/back/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="../assets/back/css/sweetalert2.min.css" rel="stylesheet">
    <link href="../assets/back/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/back/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="../assets/back/css/owl.carousel.css" type="text/css">
    <!-- Custom styles for this template -->
    <link href="../assets/back/css/datatables.min.css" rel="stylesheet">
    <link href="../assets/back/css/style.css" rel="stylesheet">
    <link href="../assets/back/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/back/js/html5shiv.js"></script>
      <script src="../../assets/back/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="index.php" class="logo">Edu<span>Site</span></a>
            <!--logo end-->

            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <?php 
                          if(!empty($_SESSION['user']['user_image']))
                          {
                            echo "<img style='width: 40px; height: 40px;' src='../uploads/users/".$_SESSION['user']['user_image']."' alt ='User Avatar'/>";
                          }
                          else
                          {
                            echo "<img style='width: 40px; height: 40px;'  src='../uploads/users/default.png' alt ='User Avatar'/>";
                          }
                          ?>
                            <span class="username"><?php echo $_SESSION['user']['user_name'];?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>
                              <a href="<?php
                                          if($_SESSION['user']['user_group'] == 1 || $_SESSION['user']['user_group'] == 2)
                                          {
                                            echo "users.php?action=profile";
                                          }
                                          elseif($_SESSION['user']['user_group'] == 3)
                                          {
                                            echo "index.php?action=profile";
                                          }
                                        ?>
                                      "><i class=" icon-suitcase"></i>Profile</a>
                            </li>
                            <li><a href="<?php echo '../logout.php' ;?>"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
