<?php include "includes/admin_header.php";?>
    <style>
        table thead tr th,
        table tbody tr td{
            text-align: center;

        }
        table tbody tr td{
            line-height: 3!important;
        }
    </style>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Posts
                        <small>dashboard</small>
                    </h1>

                    <?php
                        if(isset($_GET['source']))
                            $source = mysqli_escape_string($connection,$_GET['source']);
                        else
                            $source = '';
                        switch ($source){
                            case 'add_post':
                                include "includes/add_post.php";
                                break;
                            case 'edit_post':
                                include "includes/edit_post.php";
                                break;
                            case 'comments':
                                echo "Nice 3";
                                break;
                            default:
                                include "includes/view_all_posts.php";
                                break;
                        }

                    ?>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


    <?php include "includes/admin_footer.php";?>
