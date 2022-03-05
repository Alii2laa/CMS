<?php include "includes/db.php";?>
<?php include "includes/header.php";?>






    <!-- Navigation -->
<?php include "includes/navigation.php"?>

<?php

if(isset($_POST['liked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    //select post
    $searchPost = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $searchPost);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];
    // update post's likes
    mysqli_query($connection, "UPDATE posts SET likes = $likes + 1 WHERE post_id = $post_id");
    //insert likes
    mysqli_query($connection, "INSERT INTO likes(user_id,post_id) VALUES ($user_id, $post_id)");
}

if(isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    //select post
    $searchPostun = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResultun = mysqli_query($connection, $searchPostun);
    $post = mysqli_fetch_array($postResultun);
    $likes = $post['likes'];
    // update post's likes
    mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");
    //insert likes
    mysqli_query($connection, "UPDATE posts SET likes = $likes-1 WHERE post_id = $post_id");
}
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    if(isset($_GET['post_id'])) {
                        $post_id = escapeSqlInj($_GET['post_id']);
                        $view_posts = "UPDATE posts SET post_views_count = post_views_count + 1 ";
                        $view_posts .= " WHERE post_id = $post_id";
                        $update_comments_count = mysqli_query($connection,$view_posts);

                        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                            $query = "SELECT * FROM posts WHERE post_id = $post_id";
                        }else{
                            $query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published'";
                        }

                        $select_all_posts_query = mysqli_query($connection,$query);

                        if($select_all_posts_query){
                            $count = mysqli_num_rows($select_all_posts_query);
                        }else{
                            $count = '';
                        }

                        if($count < 1){
                            echo "<h2 class='text-center'>No posts available</h2>";
                        }else{
                        if($select_all_posts_query){
                            while ($row = mysqli_fetch_assoc($select_all_posts_query)){
                                $post_title =  $row['post_title'];
                                $post_user =  $row['post_user'];
                                $post_date =  $row['post_date'];
                                $post_img =  $row['post_img'];
                                $post_content =  $row['post_content'];

                            ?>

                            <h1 class="page-header">
                                Post
                            </h1>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="#"><?php echo $post_title;?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index"><?php echo $post_user;?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                            <hr>
                            <img class="img-responsive" src="/cms/images/<?php echo $post_img;?>" alt="">
                            <hr>
                            <p><?php echo $post_content;?>.</p>


                            <hr>
                                <?php if(isLoggedIn()){?>
                                    <div class="row">
                                        <p class="pull-right"><a class="<?php echo userLikedPosts($post_id) ? 'unlike' : 'like';?>" href=""> <span class="glyphicon glyphicon-thumbs-up"></span><?php echo userLikedPosts($post_id) ? 'Unlike' : 'Like';?></a></p>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="row">
                                        <p class="pull-right">You need <a href="/cms/login">Login</a> to like</p>
                                    </div>
                                <?php }?>


                            <div class="row">
                                <p class="pull-right">Likes : <?php getPostLikes($post_id);?></p>
                            </div>
                <?php } ?>

                <!-- Blog Comments -->

                <?php
                    if(isset($_POST['create_comment'])){
                        $post_id = $_GET['post_id'];
                        $comment_author = mysqli_escape_string($connection,$_POST['comment_author']);
                        $comment_email = mysqli_escape_string($connection,$_POST['comment_email']);
                        $comment_content = mysqli_escape_string($connection,$_POST['comment_content']);

                       if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                           $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status,comment_date) ";
                           $query .= " VALUES ($post_id,'{$comment_author}','{$comment_email}','{$comment_content}','unapproved',now())";

                           $create_comment = mysqli_query($connection,$query);


                           if(!$create_comment)
                               die("Query Failed" . mysqli_error($connection));
                           else
                               echo "Your Msg sent";

//                           $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
//                           $query .= " WHERE post_id = $post_id";
//                           $update_comments_count = mysqli_query($connection,$query);
                       }else{
                           echo "<script>alert('Form inputs should be filled')</script>";
                       }

                    }
                ?>
                <div class="well">

                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment_author" id="" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="comment_email" id="" placeholder="Your E-mail">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="comment_content" rows="3" placeholder="Comment"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                    <?php
                        $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                        $query .= " AND comment_status = 'approved' ";
                        $query .= " ORDER BY comment_id DESC";

                        $select_comments_query = mysqli_query($connection,$query);
                        if(!$select_comments_query){
                            die("Query Failed" . mysqli_error($connection));
                        }
                        while ($row = mysqli_fetch_assoc($select_comments_query)){
                            $comment_author =  $row['comment_author'];
                            $comment_date =  $row['comment_date'];
                            $comment_content =  $row['comment_content'];
                            ?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://via.placeholder.com/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author?>
                                    <small><?php echo $comment_date?></small>
                                </h4>
                                <?php echo $comment_content?>
                            </div>
                        </div>

                      <?php  }  } }
                    }else{
                        header("Location: error404.php");
                    }?>



            </div>




            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->
    </div>
    <hr>

<?php include "includes/footer.php";?>

<script>

    $(document).ready(function(){
        var post_id = <?php echo $post_id?>;
        var user_id = <?php echo loggedInUserId();?>;
        $('.like').click(function (){
            $.ajax({
                url: "/cms/post/<?php echo $post_id?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id,
                }
            })
       });

        $('.unlike').click(function (){
            $.ajax({
                url: "/cms/post/<?php echo $post_id?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id,
                }
            })
        });
    });

</script>
