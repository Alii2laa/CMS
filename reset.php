<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>



<?php
$expired = false;
    if(!isset($_GET['email']) && !isset($_GET['token'])){
        redirect('/cms');
    }


if($stmt = mysqli_prepare($connection,"SELECT user_name, user_email, token FROM users WHERE token=?")){
        mysqli_stmt_bind_param($stmt,'s',$_GET['token']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$user_name,$user_email,$token);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if(isset($_POST['resetPassword'])){
            if($user_email === $_GET['email'] && $token === $_GET['token']){
                $expired = false;
                if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
                    if($_POST['password'] === $_POST['confirmPassword']){

                        $password = escapeSqlInj($_POST['password']);

                        $hashedPassword = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12));

                        if($stmt = mysqli_prepare($connection,"UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email = ?")){
                            mysqli_stmt_bind_param($stmt,'s',$_GET['email']);
                            mysqli_stmt_execute($stmt);
                            if(mysqli_stmt_affected_rows($stmt)){
                                redirect('/cms/login');
                            }
                            mysqli_stmt_close($stmt);


                        }

                    }
                }

            }else{
                $expired = true;
            }
        }


    }
?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<style>
    .forget{
        color: #fff;
        text-decoration: none;
        background-color: #155724;
        padding: 5px;
        border-radius: 5px;
    }
    .forget:hover{
        text-decoration: none;
        color: #fff;
        background-color: #155724;
    }
</style>

<!-- Page Content -->
<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <?php if(!$expired):?>
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                                <?php else: ?>
                                    <h1 style='background-color: #721c24;color: #fff;    border-radius: 5px;padding: 10px;'>Token Expired</h1>
                                    <p>If you need another reset link click here </p>
                                    <a href='/cms/forgot?tokId=<?php echo uniqid(true);?>' class="forget">Forgot Password!</a>
                                    
                                <?php endif; ?>

                            </div><!-- Body-->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

