<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php

if(isset($_SESSION['user_role'])){
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);

    $errors = [
            'username' => '',
            'email' => '',
            'password' => ''
    ];

    if(strlen($username) < 4){
        $errors['username'] = "Must be more than 4 chars";
    }
    if($username == ''){
        $errors['username'] = "Mustn't be empty";
    }

    if(username_exists($username)){
        $errors['username'] = "Username already exists pick another one";
    }

    if($email == ''){
        $errors['email'] = "Mustn't be empty";
    }

    if(email_exists($email)){
        $errors['email'] = "Email already exists pick another one";
    }
    if(strlen($password) < 8){
        $errors['password'] = "Must be more than 8 chars";
    }
    if($password == ''){
        $errors['password'] = "Mustn't be empty";
    }

    foreach ($errors as $key => $value) {
        if(empty($value)){
            unset($errors[$key]);
        }
    }

    if(empty($errors)){
        register_user($username,$email,$password);
        login_user($username,$password);

    }


}


?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                            autocomplete="off"
                            value="<?php echo isset($username) ? $username : '' ?>">
                            <p style="background-color:#f8d7da;color:#842029;display: inline-block;margin: 10px 0px"><?php echo isset($errors['username']) ? $errors['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                                   autocomplete="off"
                                   value="<?php echo isset($email) ? $email : '' ?>">
                             <p style="background-color:#f8d7da;color:#842029;display: inline-block;margin: 10px 0px"><?php echo isset($errors['email']) ? $errors['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                             <p style="background-color:#f8d7da;color:#842029;display: inline-block;margin: 10px 0px"><?php echo isset($errors['password']) ? $errors['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
