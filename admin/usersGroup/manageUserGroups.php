<?php 
#Get All Groups From DataBase . . . 
$groups =getAllFrom("*" , "users_groups",NULL,NULL,NULL,NULL);
?>
<!-- page start-->
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    All Users Groups
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <table id="groupsTable" class="table table-bordered table-striped table-condensed display">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($groups))
                                    {
                                        foreach($groups as $group)
                                        {
                                            $groupId   = $group["group_id"];
                                            $groupName = $group["group_name"];
                                ?>
                                            <tr>
                                                <td><strong><?php echo $groupId; ?></strong></td>
                                                <td><strong><a href="usersgroups.php?action=update&gid=<?php echo $groupId; ?>"><?php echo $groupName ; ?></a></strong></td>
                                                <td>
                                                    <a href="usersgroups.php?action=update&gid=<?php echo $groupId; ?>" type="button" class="btn btn-info "><i class="icon-refresh"></i> Update</a>
                                                    <a href="usersgroups.php?action=delete&gid=<?php echo $groupId; ?>" type="button" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                <?php  }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="3">No Users Groups Found</td></tr>';
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