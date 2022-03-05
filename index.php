<?php include "includes/db.php";?>
<?php include "includes/header.php";?>

    <?php
    $session = session_id();
    $query = "SELECT user_name,users_online.id FROM users LEFT JOIN users_online ON "
    ?>




    <!-- Navigation -->
    <?php include "includes/navigation.php"?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">


                <?php
                    $per_page = 5;
                    if(isset($_GET['page'])){
                        $page = escapeSqlInj($_GET['page']);
                    }else{
                        $page = "";
                    }
                    if($page == "" || $page == 1){
                        $page_1 = 0;
                    }else{
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                        $query = "SELECT * FROM posts";
                    }else{
                        $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT {$page_1},{$per_page} ";
                    }

                    $find_count = mysqli_query($connection,$query);
                    if($find_count){
                        $count = mysqli_num_rows($find_count);
                    }else{
                        $count = '';
                    }
                    if($count < 1){
                        echo "<h2 class='text-center'>No posts available</h2>";
                    }else{
                        if($query){
                        $count = ceil($count / 5);

                        $select_all_posts_query = mysqli_query($connection,$query);
                        while ($row = mysqli_fetch_assoc($select_all_posts_query)){
                            $post_id = $row['post_id'];
                            $post_title =  $row['post_title'];
                            $post_user =  $row['post_user'];
                            $post_date =  $row['post_date'];
                            $post_img =  $row['post_img'];
                            $post_content =  substr($row['post_content'],0,100);
                            $post_status =  $row['post_status'];

                                ?>

                                <h1 class="page-header">
                                    Page Heading
                                    <small>Secondary Text</small>
                                </h1>

                                <!-- First Blog Post -->
                                <h2>
                                    <a href="post/<?php echo $post_id?>"><?php echo $post_title;?></a>
                                </h2>
                                <p class="lead">
                                    All Posts By  <a href="author_posts.php?author=<?php echo $post_user?>&post_id=<?php echo $post_id;?>"><?php echo $post_user;?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                                <hr>
                                <a href="post.php?post_id=<?php echo $post_id?>"><img class="img-responsive" src="images/<?php echo $post_img;?>" alt=""></a>
                                <hr>
                                <p><?php echo $post_content;?></p>
                                <a class="btn btn-primary" href="post?post_id=<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>
                    <?php } } }?>


            </div>




            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->
    </div>
        <hr>
    <ul class="pager">
        <?php
            for($i = 1; $i <= $count;$i++){
                if($i == $page) {
                    echo "<li><a class='active' href='index?page={$i}'>{$i}</a></li>";
                }else{
                    echo "<li><a href='index?page={$i}'>{$i}</a></li>";
                }
            }
        ?>

    </ul>

    <?php include "includes/footer.php";?>