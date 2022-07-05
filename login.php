<?php   
    require  "globals.php";
    if(checkLogin())
    {
        invalidRedirect($_SESSION['user']['user_group']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="assets/back/img/mooclogo.jpg">

    <title>Login EduSite</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/back/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/back/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/back/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/back/css/style.css" rel="stylesheet">
    <link href="assets/back/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login']))
        {
            $email    = $_POST['userEmail'];
            $password = $_POST['password'];
            $errors = [];

            #Validate Email . . . 
            if(!Validate($email, "required"))
            {
                $errors["Eamil"] ="Eamil Is Required ";
            }
            elseif(!Validate($email, "email"))
            {
                $errors["Eamil"] ="Eamil  Is Not Valid ";
            }

            #Validate Password . . . . 
            if(!Validate($password, "required"))
            {
                $errors["Password"] ="Password Is Required ";
            }
            elseif(!Validate($password, "password"))
            {
                $errors["Password"] ="Password  Is Not Correct ";
            }

            if(empty($errors))
            {
                login($email,$password);

                if(login($email,$password))
                {
                    invalidRedirect($_SESSION['user']['user_group']);
                }
                else
                {
                    $_SESSION['errors'] = "somthing Went Wrong In Login Request";
                    header("refresh:2;url=".$_SERVER['PHP_SELF']."");
                }
                
            }
        }
    ?>
    <div class="container">
        <!-- Start Login Form  -->
        <form class="form-signin" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <h2 class="form-signin-heading">sign in now</h2>
            <?php
                echo getErrors();
                echo getSuccessMsg();
    
                if(!empty($errors))
                {
                    echo '<div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="icon-remove"></i>
                    </button>';
                    foreach($errors as $key => $error)
                    {
                        echo '<span><strong>'.$key.' : </strong>'.$error.'</span><br>';
                    }
                    echo '</div>';
                }
            ?>
            <div class="login-wrap">
                <input type="text" class="form-control" placeholder="Email"    name="userEmail">                
                <input type="password" class="form-control" placeholder="Password"    name="password">                
                <label class="checkbox">
                    <span class="pull-right">
                        <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                    </span>
                </label>
                <input type="submit" class="btn btn-lg btn-login btn-block"  value="Sign In" name="login"/>

                <div class="registration">
                    Don't have an account yet?
                    <a class="" href="register.php">
                        Create an account
                    </a>
                </div>

            </div>

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="login.php" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Forgot Password ?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter your e-mail address below to reset your password.</p>
                                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                <input class="btn btn-success" type="submit" value="Send" name="resetPass">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->
        </form>
        <!-- End  Login Form  -->
    </div>


<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/back/js/jquery.js"></script>
<script src="assets/back/js/bootstrap.min.js"></script>

</body>
</html>
