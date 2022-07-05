
        <!-- Start Profile Info  -->
        <div class="profile-info">
            <div class="page-header">
                <h1 class="text-center"><?php echo $studentData[0]['user_name']?> Profile</h1>
            </div>
            <div class="info-box">
                <div class="user-pic float-left">
                    <img class='img-fluid' src= '../uploads/users/<?php echo $studentData[0]['user_image']?>' alt='User Avatar'> 
                </div>
                <div class="user-info float-left">
                    <h4><span><i class="fa fa-unlock-alt "></i> Username : </span> <?php echo $studentData[0]['user_name']?></h4>
                    <h5><span><i class="fa fa-envelope "></i> Email : </span> <?php echo $studentData[0]['email']?></h5>
                    <hr>
            </div> 
            <div class="clearfix"></div>
        </div>
