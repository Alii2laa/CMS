
<?php

    if(isset($_GET['post_id'])) {
        $the_post_id = escapeSqlInj($_GET['post_id']);
    }
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_post_by_id = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_post_by_id)) {
            $post_id = $row['post_id'];
            $post_user = $row['post_user'];
            $post_title = $row['post_title'];
            $post_category = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_img = $row['post_img'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comments = $row['post_comment_count'];
            $post_date = $row['post_date'];

        }
        if(isset($_POST['post_edit'])){
            $post_title        = escapeSqlInj($_POST['post_title']);
            $post_category_id  = escapeSqlInj($_POST['post_category_id']);
            $post_user      = escapeSqlInj($_POST['post_user']);
            $post_status       = escapeSqlInj($_POST['post_status']);
            $post_img          =  escapeSqlInj($_FILES['post_img']['name']);
            $post_img_temp     =  $_FILES['post_img']['tmp_name'];
            $post_tags         = escapeSqlInj($_POST['post_tags']);
            $post_content      = escapeSqlInj($_POST['post_content']);
            move_uploaded_file($post_img_temp, "../images/$post_img");
            if(empty($post_img)){

                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_img = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_img)) {
                    $post_img = $row['post_img'];
                }
            }

            $query = "UPDATE posts SET ";
            $query .= "post_title = '{$post_title}', ";
            $query .= "post_category_id = '{$post_category_id}', ";
            $query .="post_date   =  now(), ";
            $query .= "post_user = '{$post_user}', ";
            $query .= "post_status = '{$post_status}', ";
            $query .= "post_tags = '{$post_tags}', ";
            $query .= "post_content = '{$post_content}', ";
            $query .="post_img  = '{$post_img}' ";
            $query .= "WHERE post_id = {$the_post_id}";

            $querymaker = mysqli_query($connection,$query);
            if($querymaker){
                echo "<p class='bg-success'>Post Updated: <a href='../post.php?post_id={$the_post_id}'>View Post</a>
                     OR Edit other post: <a href='posts.php'>Post Dashboard</a> 
                </p>";
            }else{
                echo "Nooooooooo";
            }



        }

?>
<style>
    .form-select{
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
</style>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control" name="post_title" value="<?php echo htmlspecialchars(stripslashes($post_title)); ?>">
        </div>


        <div class="form-group">
            <label for="post_category">Post CAT Id</label> <br>
            <select class="form-select" name="post_category_id" id="">
                <?php

                    $query = "SELECT * FROM categories";
                    $selector_query = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($selector_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        if($cat_id == $post_category){
                            echo "<option selected value='{$cat_id}' >{$cat_title}</option>";
                        }else{
                            echo "<option value='{$cat_id}' >{$cat_title}</option>";
                        }
                    }



                ?>
            </select>


        </div>

        <div class="form-group">
            <label for="users">Users</label>
            <select class="form-select" name="post_user" id="">
                <?php
                echo "<option value='{$post_user}' >{$post_user}</option>";
                $query = "SELECT * FROM users";
                $selector_query_users = mysqli_query($connection,$query);
                while ($row = mysqli_fetch_assoc($selector_query_users)){
                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];

                    echo "<option value='{$user_name}' >{$user_name}</option>";

                }

                ?>
            </select>
        </div>



        <div class="form-group">
            <label for="Status">Post Status</label> <br>
            <select class="form-select" name="post_status" id="">
                <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>

                <?php

                if($post_status == 'published')
                    echo "<option value='drafted' >Drafted</option>";
                else
                    echo "<option value='published' >Published</option>";
                ?>

            </select>
        </div>

        <div class="form-group">
            <img style="margin-bottom: 10px" width="100px" src="../images/<?php echo $post_img;?>"" alt="">
            <input type="file"  name="post_img">
        </div>

        <div class="form-group">
            <label for="post_tags">Post Tags</label>
            <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags;?>">
        </div>

        <div class="form-group">
            <label for="post_content">Post Content</label>
            <textarea class="form-control "name="post_content" id="body" cols="30" rows="10">
                <?php echo $post_content;?>
         </textarea>
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="post_edit" value="Publish Post">
        </div>

</form>