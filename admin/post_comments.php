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
        Welcome to Comments
        <small>dashboard</small>
    </h1>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>

            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_GET['id'])){
                $id = mysqli_real_escape_string($connection,$_GET['id']);

            $query = "SELECT * FROM comments WHERE comment_post_id = $id";
            $select_all_comments = mysqli_query($connection,$query);

            if($select_all_comments){
            while ($row = mysqli_fetch_assoc($select_all_comments)){
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];






                echo "<tr>";
                echo "<td>{$comment_id}</td>";
                echo "<td>{$comment_author}</td>";
                echo "<td>{$comment_content}</td>";
                echo "<td>{$comment_email}</td>";



                echo "<td>{$comment_status}</td>";
                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                $select_post_id = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_post_id)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    echo "<td><a href='../post.php?post_id={$post_id}'>{$post_title}</a></td>";

                }
                echo "<td>{$comment_date}</td>";

                echo "<td><a href='post_comments.php?approve=$comment_id&id=$id'>Approve</a></td>";
                echo "<td><a href='post_comments.php?unapprove=$comment_id&id=$id'>Unapprove</a></td>";
                echo "<td><a href='post_comments.php?delete=$comment_id&id=$id'>Delete</a></td>";
                echo "</tr>";
            } } }?>




            </tbody>
        </table>

        <?php
        if(isset($_GET['approve'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $comment_status = $_GET['approve'];
                    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_status}";
                    $approve_comment_query = mysqli_query($connection,$query);
                    header("Location: post_comments.php?id=$id");
                }
            }



        } elseif (isset($_GET['unapprove'])) {
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $comment_status = $_GET['unapprove'];
                    $query = "UPDATE comments SET comment_status = 'unapprove' WHERE comment_id = {$comment_status}";
                    $unapprove_comment_query = mysqli_query($connection,$query);
                    header("Location: post_comments.php?id=$id");
                }
            }


        } elseif(isset($_GET['delete'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $delete_comment = $_GET['delete'];
                    $query = "DELETE FROM comments WHERE comment_id ={$delete_comment}";
                    $delete_query = mysqli_query($connection,$query);
                    header("Location: post_comments.php?id=$id");
                }
            }


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
