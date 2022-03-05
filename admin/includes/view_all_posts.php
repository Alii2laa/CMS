<?php
    include "delete_modal.php";
    if(isset($_POST['checkArray'])){
        foreach ($_POST['checkArray'] as $postValueID){
            $bulk_options = escapeSqlInj($_POST['bulk_options']);
            switch ($bulk_options){
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueID";
                    $PostStatusPublished = mysqli_query($connection,$query);
                    break;
                case 'drafted':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueID";
                    $PostStatusDrafted = mysqli_query($connection,$query);
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = $postValueID";
                    $PostDelete = mysqli_query($connection,$query);
                    break;
                case 'clone':
                    $query = "SELECT * FROM posts WHERE post_id = $postValueID";
                    $clone_posts = mysqli_query($connection,$query);

                    while ($row = mysqli_fetch_assoc($clone_posts)) {

                        $post_category = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_img = $row['post_img'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        $post_status = $row['post_status'];
                        $post_date = $row['post_date'];

                        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_img, post_content,post_tags,post_status,post_date) ";

                        $query .= " VALUES($post_category,'$post_title','$post_user','$post_img','$post_content','$post_tags','$post_status',now())";

                        $cloned_posts = mysqli_query($connection, $query);
                        if (!$cloned_posts) {
                            die("Query Failed");
                        }
                    }
                    break;
            }
        }
    }
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="drafted">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div>
        <div class="col-xs-4">

            <button type="submit">Apply</button>
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

        </div>
        <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>ID</th>
            <th>User</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Images</th>
            <th>Content</th>
            <th>Tages</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views</th>
            <th>Reset Views</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
//        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $query = "SELECT * , categories.cat_id , categories.cat_title  FROM posts ";
        $query .= "LEFT JOIN categories ";
        $query .= "ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC";
        $select_all_posts = mysqli_query($connection,$query);

        while ($row = mysqli_fetch_assoc($select_all_posts)){
            $post_id = $row['post_id'];
            $post_user = $row['post_user'];
            $post_title = $row['post_title'];
            $post_category = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_img = $row['post_img'];
            $post_tags = $row['post_tags'];
            $post_comments = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_content = $row['post_content'];
            $post_views = $row['post_views_count'];
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";
            ?>
            <td><input class='checkBoxes' type='checkbox' name='checkArray[]' value="<?php echo $post_id?>"></td>
            <?php
            echo "<td>{$post_id}</td>";

            if(!empty($post_author)){
                echo "<td>{$post_author}</td>";
            }elseif(!empty($post_user)){
                echo "<td>{$post_user}</td>";
            }




            echo "<td><a href='../post.php?post_id={$post_id}'>{$post_title}</a></td>";

//            $query = "SELECT * FROM categories WHERE cat_id = $post_category";
//            $select_cat_id = mysqli_query($connection,$query);
//            while($row = mysqli_fetch_assoc($select_cat_id)){

                echo "<td>{$cat_title}</td>";

//             }

            echo "<td>{$post_status}</td>";
            echo "<td><img width='100px'  src='../images/{$post_img}' ></td>";
            echo "<td>{$post_content}</td>";
            echo "<td>{$post_tags}</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
            $send_query_count = mysqli_query($connection,$query);
            $post_comments = mysqli_num_rows($send_query_count);
            echo "<td><a href='post_comments.php?id=$post_id'>$post_comments</a></td>";



            echo "<td>{$post_date}</td>";
            echo "<td>{$post_views}</td>";
            echo "<td><a href='posts.php?reset={$post_id}'>Reset Views</a></td>";
            echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";
            echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";

            //echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";

        } ?>




        </tbody>
    </table>
</form>
<?php

    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                $delete_post = escapeSqlInj($_GET['delete']);
                $query = "DELETE FROM posts WHERE post_id = $delete_post";
                $delete_query = mysqli_query($connection,$query);
                header("Location: posts.php");
            }
        }

    }elseif(isset($_GET['reset'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                $select_post = escapeSqlInj($_GET['reset']);
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $select_post";
                $reset_query = mysqli_query($connection,$query);
                header("Location: posts.php");
            }
        }

    }

?>

<script>
    $(document).ready(function(){
        $(".delete_link").on('click',function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id +" ";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>
