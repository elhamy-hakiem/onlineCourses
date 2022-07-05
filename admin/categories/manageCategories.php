<?php 
#Get All Categories From DataBase . . . 
$categories =getAllFrom
                        ("`course_categories`.*,`users`.`user_name`" ,
                            "course_categories",
                            " LEFT JOIN `users`",
                            "ON`course_categories`.`created_by` = `users`.`user_id`",
                            NULL,
                            NULL
                        );
?>

<!-- page start-->
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    All Categories
                </header>
                <div class="panel-body">
                    <section id="unseen">
                    <table id="categoriesTable" class="table table-bordered table-striped table-condensed display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Created By</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($categories))
                                {
                                    foreach($categories as $category)
                                    {
                                        $catId   = $category["category_id"];
                                        $catName = $category["category_name"];
                                        $user    = $category["user_name"];
                            ?>
                                        <tr>
                                            <td><strong><?php echo $catId; ?></strong></td>
                                            <td><strong><a href="categories.php?action=update&catid=<?php echo $catId; ?>"><?php echo $catName; ?></a></strong></td>
                                            <td><strong><?php echo $user; ?></strong></td>
                                            <td>
                                                <a href="courses.php?action=manage&cid=<?php echo $catId; ?>" type="button" class="btn btn-success"><i class="icon-eye-open"></i> View</a>
                                                <a href="categories.php?action=update&catid=<?php echo $catId; ?>" type="button" class="btn btn-info "><i class="icon-refresh"></i> Update</a>
                                                <a href="categories.php?action=delete&catid=<?php echo $catId; ?>" type="button" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                            <?php  }
                                }
                                else
                                {
                                    echo '<tr><td colspan="4">No Categories Found</td></tr>';
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