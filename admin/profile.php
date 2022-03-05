<?php include "includes/admin_header.php";?>

<?php
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $user_id ";

    $select_user_profile = mysqli_query($connection, $query);

    if (!$select_user_profile) {
        die("Query Failed" . " " . mysqli_error($connection));
    }

    if ($select_user_profile) {
        while ($row = mysqli_fetch_assoc($select_user_profile)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_email = $row['user_email'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];

        }
    }
}
if(isset($_POST['update_profile'])){

        $user_firstname =  $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_name = $_POST['user_name'];
        $user_email  = $_POST['user_email'];
        $user_password  = $_POST['user_password'];

        echo $user_firstname;


        // Update profile;
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
                    user_email = '{$user_email}' WHERE user_id = $user_id";
            $update_data = mysqli_query($connection,$query);
            if($update_data){
                echo "Done";
            }else{
                echo "No";
            }



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

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
<!--                    <h1 class="page-header">-->
<!--                        Welcome to Profile-->
<!--                        <small>-->
<!--                            --><?php
//                            if(isset($_SESSION['userName'])){
//                                echo $_SESSION['userName'];
//                            }
//                            ?>
<!--                        </small>-->
<!--                    </h1>-->
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
                            <input type="password" class="form-control" name="user_password" required value="<?php // $user_password; ?>">
                        </div>


                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                        </div>

                    </form>



                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


    <?php include "includes/admin_footer.php";?>
