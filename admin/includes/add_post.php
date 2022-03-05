
<?php
    if(isset($_POST['create_post'])){
        $post_title =  escapeSqlInj($_POST['post_title']);
        $post_user = escapeSqlInj($_POST['post_user']);
        $post_category_id  = escapeSqlInj($_POST['post_category_id']);
        $post_status = escapeSqlInj($_POST['post_status']);

        $post_img = $_FILES['post_img']['name'];
        $post_img_temp = $_FILES['post_img']['tmp_name'];

        $post_tags  = escapeSqlInj($_POST['post_tags']);
        $post_content  = escapeSqlInj($_POST['post_content']);
        $post_date  = date('d-m-y');


        move_uploaded_file($post_img_temp,"../images/$post_img");
        //echo $post_title . " " . $post_author ." " .$post_category_id . " " . $post_status ." " .$post_img . " " . $post_img_temp ." " .$post_tags . " " . $post_content ." " .$post_date;

        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_img, post_content,post_tags,post_status) ";

        $query .= " VALUES($post_category_id,'$post_title','$post_user','$post_img','$post_content','$post_tags','$post_status')";

        $insert_data = mysqli_query($connection,$query);
        if($insert_data){
            $the_post_id = mysqli_insert_id($connection);
            echo "<p class='bg-success'>Post Added: <a href='../post.php?post_id={$the_post_id}'>View Post</a>
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
        <input type="text" class="form-control" name="post_title" required>
    </div>


    <div class="form-group">
        <label for="post_category">Post CAT Id</label> <br>
        <select class="form-select" name="post_category_id" id="">
            <?php

            $query = "SELECT * FROM categories";
            $selector_query = mysqli_query($connection,$query);
            while ($row = mysqli_fetch_assoc($selector_query)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='{$cat_id}' >{$cat_title}</option>";

            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select class="form-select" name="post_user" id="">
            <?php

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

        <select name="post_status" id="">
            <option value="drafted">Post Status</option>
            <option value="published">Published</option>
            <option value="drafted">Drafted</option>
        </select>
    </div>

    <div class="form-group">
        <input type="file"  name="post_img" required>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" required>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10" required>
         </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>