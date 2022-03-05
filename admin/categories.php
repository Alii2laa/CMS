<?php include "includes/admin_header.php";?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>dashboard</small>
                    </h1>


                    <div class="col-xs-6">
                        <?php AddNewCatogery() ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">
                                    Add Category
                                </label>
                                <input type="text" name="cat_title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="cat_submit" value=" Add Category" class="btn btn-primary">
                            </div>

                        </form><!-- CAT add -->

                        <?php
                            if(isset($_GET['edit'])){
                                 include "includes/update_CAT.php";
                            }
                        ?>

                    </div>


                    <div class="col-xs-6">
                        <style>
                            th{
                                text-align: center;
                            }
                            table tbody tr th a:first-child{
                                padding: 5px;
                                margin-right: 10px;
                                color: #ffffff;
                                text-decoration: none;
                                background-color: #f00;
                            }
                        </style>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Tittle</th>
                                <th>Category Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                                $query = "SELECT * FROM categories";
                                $select_all_cat_query = mysqli_query($connection,$query);
                                while ($row = mysqli_fetch_assoc($select_all_cat_query)){
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                ?>
                                    <tr>
                                        <th><?php echo $cat_id;?></th>
                                        <th><?php echo $cat_title;?></th>
                                        <th>
                                            <a href="categories.php?delete=<?php echo $cat_id?>">Delete</a>
                                            <a href="categories.php?edit=<?php echo $cat_id?>">Edit</a>
                                        </th>
                                    </tr>
                               <?php } ?>
                            <?php
                                DeleteCategory();
                            ?>




                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


    <?php include "includes/admin_footer.php";?>
