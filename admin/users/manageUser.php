<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <a class="text-primary"  href="users.php?action=manage"> All Users </a> || 
                <a class="text-primary" href="users.php?action=manage&gid=1">Super Admins</a> || 
                <a class="text-primary"  href="users.php?action=manage&gid=2"> Admins</a> ||
                <a class="text-primary"  href="users.php?action=manage&gid=3">Instructors</a> ||
                <a class="text-primary" href="users.php?action=manage&gid=4">Students</a>
            </header>
            <div class="panel-body">
                <section id="unseen">
                    <!-- <input style="margin-bottom: 10px; width: 200px;" type="search" class="form-control" placeholder="Search" id="searchUsers"> -->
                    <table id="usersTable" class="table table-bordered table-striped table-condensed display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Group</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $groupId = isset($_GET['gid']) && is_numeric($_GET['gid']) ? intval($_GET['gid']) :0;
                                if($groupId > 0)
                                {
                                    $users = getUsersByGroup($groupId);
                                }
                                else
                                {
                                    $users = getAllFrom(
                                        "users.* ,users_groups.group_name" ,
                                        "users",
                                        "LEFT JOIN `users_groups`",
                                        " ON `users`.`user_group` = `users_groups`.`group_id`",
                                        "",
                                        null
                                    );
                                }
                                if(!empty($users))
                                {
                                    foreach($users as $user)
                                    {
                                        $userid      = $user["user_id"];
                                        $username    = $user["user_name"];
                                        $userImage   = $user["user_image"];
                                        $email       = $user["email"];
                                        $group       = $user["group_name"];
                                        $groupid     = $user["user_group"];
                            ?>
                                        <tr>
                                            <td><?php echo $userid; ?></td>
                                            <td>
                                                <?php
                                                    if(!empty($userImage) && file_exists(UPLOADS."/users/".$userImage))
                                                    {
                                                ?>
                                                        <img id="userAvatar"  src='<?php echo "../uploads/users/$userImage" ;?>' alt ='User Avatar'/>
                                                <?php 
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <img id="userAvatar"  src='<?php echo "../uploads/users/default.png" ;?>' alt ='User Avatar'/>
                                                <?php 
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo $email; ?></td>
                                            <td><a href="users.php?action=manage&gid=<?php echo $groupid; ?>"  class="btn btn-success"><i class="icon-user"></i> <?php echo $group; ?></a></td>

                                            <td>
                                                <a href="users.php?action=update&userid=<?php echo $userid; ?>" type="button" class="btn btn-info "><i class="icon-refresh"></i> Update</a>
                                                <a href="users.php?action=delete&userid=<?php echo $userid; ?>" type="button" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                            <?php  }
                                }
                                else
                                {
                                    echo '<tr><td colspan="5">No Users Found</td></tr>';
                                }
                            ?>
                        </tbody>
                </table>
                </section>
            </div>
        </section>
    </div>
</div>
<!-- page end-->
