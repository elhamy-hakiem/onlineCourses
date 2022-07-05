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

    <title>Register EduSite</title>

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
          if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register']))
          {
              $name      = cleanInput($_POST['username']);
              $email     = cleanInput($_POST['useremail']);
              $password  = cleanInput($_POST['password']);
              $usergroup = (isset($_POST["usergroup"]) && !empty($_POST["usergroup"])) ? intval($_POST["usergroup"]): 0;
              $usergroupArray = array(3,4);
              $errors = [];

              #Validate Name . . . . 
              if(!Validate($name, "required"))
              {
                $errors["username"] ="User Is Required ";
              }
              elseif(!Validate($name, "min"))
              {
                $errors["username"] ="User Min length 6 Char ";
              }
              elseif(!Validate($name, "string"))
              {
                $errors["username"] ="User Must Be String ";
              }

              #Validate Eamil . . . . 
              $user = getAllFrom(
                "email" ,
                "users",
                "",
                "",
                "WHERE `email`= '$email'",
                "LIMIT 1"
              );
              if(!empty($user))
              {
                $errors["Eamil"] ="Email Already Exist Insert Another";
              }
              elseif(!Validate($email, "required"))
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

              #Validate UserGroup . . . . 
              if(!Validate($usergroup, "required"))
              {
                $errors["UserGroup"] ="User Type Is Required ";
              }
              if(!in_array($usergroup,$usergroupArray))
              {
                $errors["UserGroup"] ="User Type Not Correct";
              }

              if(empty($errors))
              {
                $tableName = "users";
                $dataInputs = array(
                  "user_name"  => $name,
                  "email"      => $email,
                  "password"   => hashPasswords($password),
                  "user_group" => $usergroup
                );
                if(Insert($tableName,$dataInputs))
                {
                  $_SESSION['successMsg'] = "User Added Success";
                  header("refresh:.5;url=".$_SERVER['PHP_SELF']."");
                }
                else
                {
                  $_SESSION['errors'] = "somthing Went Wrong In Register Insert";
                  header("refresh:1;url=".$_SERVER['PHP_SELF']."");
                }
              }
          }
      ?>
    <div class="container">

      <form class="form-signin" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <h2 class="form-signin-heading">registration now</h2>
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
            <input type="text"     name="username" class="form-control" placeholder="Username" autofocus>
            <input type="text"     name="useremail"    class="form-control" placeholder="Email"    autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password" autofocus>

            <div class="radios">
                <label class="label_radio col-lg-6 col-sm-6">
                    <input type="radio" name="usergroup"  value="3"/> Instructor
                </label>
                <label class="label_radio col-lg-6 col-sm-6">
                    <input type="radio" name="usergroup"  value="4"/> Student
                </label>
            </div>

            <input type="submit" name="register" class="btn btn-lg btn-login btn-block" value="Register">
            <div class="registration">
                Already Registered.
                <a class="" href="login.php">
                    Login
                </a>
            </div>

        </div>

      </form>

    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/back/js/jquery.js"></script>
    <script src="assets/back/js/bootstrap.min.js"></script>
  </body>
</html>
