
<?php


    if(isset($_GET['edit_user'])) {
        $user_id = htmlentities($_GET['edit_user']);
    }
    $query = $query = "SELECT * FROM users WHERE user_id = {$user_id}";

    $select_user_by_id = mysqli_query($connection, $query);
    if($select_user_by_id){
        while ($row = mysqli_fetch_assoc($select_user_by_id)) {
            $user_firstname =  $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role  = $row['user_role'];
            $user_name = $row['user_name'];
            $user_email  = $row['user_email'];
            $user_password  = $row['user_password'];
        }
    }else{
        $user_firstname =  '';
        $user_lastname = '';
        $user_role  = '';
        $user_name = '';
        $user_email  = '';
        $user_password = '';
        header("Location: ../error404.php");
    }





if(isset($_POST['update_user'])){

    $user_firstname =  $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role  = $_POST['user_role'];
    $user_name = $_POST['user_name'];
    $user_email  = $_POST['user_email'];
    $user_password  = $_POST['user_password'];


    //move_uploaded_file($post_img_temp,"../images/$post_img");

    if(!empty($user_password)){
        $query_password = "SELECT user_password FROM users WHERE user_id = $user_id";
        $get_user = mysqli_query($connection,$query_password);
        $row = mysqli_fetch_assoc($get_user);
        $db_user_password = $row['user_password'];

        if($db_user_password != $user_password) {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        }

        $query = "UPDATE users SET 
                    user_name = '{$user_name}' ,
                    user_password = '{$hashed_password}' ,
                    user_firstname = '{$user_firstname}' ,
                    user_lastname = '{$user_lastname}' ,
                    user_email = '{$user_email}' ,
                    user_role = '{$user_role}' WHERE user_id = $user_id";
        $insert_data = mysqli_query($connection,$query);
        if($insert_data){
            echo "Done";
            //header("Location: users.php");
        }else{
            echo "Nooooooooo";
        }



    }


    //echo $post_title . " " . $post_author ." " .$post_category_id . " " . $post_status ." " .$post_img . " " . $post_img_temp ." " .$post_tags . " " . $post_content ." " .$post_date;





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
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="user_firstname" required value="<?php echo $user_firstname; ?>">
    </div>

    <div class="form-group">
        <label for="author">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" required value="<?php echo $user_lastname; ?>">
    </div>


    <div class="form-group">
        <label for="post_category">Role</label> <br>
        <select class="form-select" name="user_role" id="">
            <option value='<?php echo $user_role; ?>' ><?php echo $user_role; ?></option>

            <?php

                if($user_role == 'admin')
                    echo "<option value='user' >user</option>";
                else
                    echo "<option value='admin' >admin</option>";
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="author">Username</label>
        <input type="text" class="form-control" name="user_name" required value="<?php echo $user_name; ?>">
    </div>

    <div class="form-group">
        <label for="Status">Email</label>
        <input type="email" class="form-control" name="user_email" required value="<?php echo $user_email; ?>">
    </div>

    <!--    <div class="form-group">-->
    <!--        <input type="file"  name="post_img" required>-->
    <!--    </div>-->

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password" required>
    </div>


    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update user">
    </div>

</form>