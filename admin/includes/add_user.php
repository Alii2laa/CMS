
<?php
if(isset($_POST['create_user'])){

    $user_firstname =  $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role  = $_POST['user_role'];
    $user_name = $_POST['user_name'];
    $user_email  = $_POST['user_email'];
    $user_password  = $_POST['user_password'];

    $user_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 12));
    //move_uploaded_file($post_img_temp,"../images/$post_img");
    //echo $post_title . " " . $post_author ." " .$post_category_id . " " . $post_status ." " .$post_img . " " . $post_img_temp ." " .$post_tags . " " . $post_content ." " .$post_date;

    $query = "INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_email,user_role) ";

    $query .= " VALUES('$user_name','$user_password','$user_firstname','$user_lastname','$user_email','$user_role')";

    $insert_data = mysqli_query($connection,$query);
    if($insert_data){
        echo "User Created: " . "<a href='users.php'>Users Dashboard</a>";
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
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="user_firstname" required>
    </div>

    <div class="form-group">
        <label for="author">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" required>
    </div>


    <div class="form-group">
        <label for="post_category">Role</label> <br>
        <select class="form-select" name="user_role" id="">
            <option>Select Option</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
<!--            --><?php
//
//            $query = "SELECT * FROM users";
//            $selector_query = mysqli_query($connection,$query);
//            while ($row = mysqli_fetch_assoc($selector_query)){
//                $user_id = $row['user_id'];
//                $user_role = $row['user_role'];
//
//                echo "<option value='{$user_id}' >{$user_role}</option>";
//
//            }
//
//            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="author">Username</label>
        <input type="text" class="form-control" name="user_name" required autocomplete="off">
    </div>

    <div class="form-group">
        <label for="Status">Email</label>
        <input type="email" class="form-control" name="user_email" required autocomplete="off">
    </div>

<!--    <div class="form-group">-->
<!--        <input type="file"  name="post_img" required>-->
<!--    </div>-->

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" class="form-control" name="user_password" required>
    </div>


    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add user">
    </div>

</form>