<?php include "includes/db.php";?>
<?php include "includes/header.php";?>






    <!-- Navigation -->
<?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                if(isset($_GET['category'])) {
                    $cat_id = escapeSqlInj($_GET['category']);

                    if(is_admin($_SESSION['userName'])){
                        $query = "SELECT * FROM posts WHERE post_category_id = $cat_id";
                    }else{
                        $query = "SELECT * FROM posts WHERE post_category_id = $cat_id AND post_status = 'published'";
                    }

                    $select_all_posts_query = mysqli_query($connection,$query);

                    if($select_all_posts_query){
                        $count = mysqli_num_rows($select_all_posts_query);
                    }else{
                        $count = '';
                    }
                if($count < 1){
                    echo "<h2 class='text-center'>No Cats available</h2>";
                }else{
                if($select_all_posts_query){
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_id = $row['post_id'];
                        $post_title =  $row['post_title'];
                        $post_user =  $row['post_user'];
                        $post_date =  $row['post_date'];
                        $post_img =  $row['post_img'];
                        $post_content =  substr($row['post_content'],0,300);
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="/cms/post/<?php echo $post_id?>"><?php echo $post_title;?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index"><?php echo $post_user;?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                    <hr>
                    <a href="post/<?php echo $post_id?>"><img class="img-responsive" src="/cms/images/<?php echo $post_img;?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content;?></p>
                    <a class="btn btn-primary" href="/cms/post/<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                <?php } }  } } ?>


            </div>




            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->
    </div>
    <hr>

<?php include "includes/footer.php";?>