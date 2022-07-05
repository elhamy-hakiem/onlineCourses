<div class="container" style="padding-top:30px;">
    <div class="row">
        <aside class="profile-nav col-lg-3">
            <section class="panel">
                <div class="user-heading round">
                    <?php
                        $userImage = $_SESSION['user']['user_image'];
                        if(!empty($userImage) && file_exists(UPLOADS."/users/".$userImage))
                        {
                    ?>
                        <a><img src='<?php echo "../uploads/users/$userImage" ;?>' alt ='User Avatar'/></a>
                    <?php 
                        }
                        else
                        {
                    ?>
                        <a><img src='<?php echo "../uploads/users/default.png" ;?>' alt ='User Avatar'/></a>
                    <?php 
                        }
                    ?>
                    <h1><?php echo $_SESSION['user']['user_name']  ;?></h1>
                    <p><?php echo $_SESSION['user']['email'] ;?></p>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li><a><i class="icon-user"></i><strong><?php echo $_SESSION['user']['group_name'];?></strong></a></li>
                </ul>

            </section>
        </aside>
        <aside class="profile-info col-lg-9">
            <?php
                #Show Errors Or Success
                echo getErrors();
                echo getSuccessMsg();
                // Start Show Errors 
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
            <section class="panel">
                <div class="panel-body bio-graph-info">
                    <h1> Profile Info</h1>
                    <form role="form" action="?action=profile" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $_SESSION['user']['user_name'] ;?>">
                        </div>
        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="hidden" name="oldpassword" value="<?php echo  $_SESSION['user']['password']?>">
                            <input type="password" class="form-control" placeholder="Enter Password" name="password">
                        </div>
        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" name="useremail" value="<?php echo $_SESSION['user']['email'] ;?>">
                        </div>
        
                        <div class="form-group">
                            <label>Image</label>
                            <input type="hidden" name="oldImage" value="<?php echo  $_SESSION['user']['user_image']?>">
                            <input type="file" class="form-control" name="userImage">
                        </div>
        
                        <input type="submit" class="btn btn-success" value="Save" name="updateprofile">
                    </form>    
                </div>
            </section>
        </aside>
    </div>
</div>