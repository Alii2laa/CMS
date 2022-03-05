
<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './vendor/autoload.php';

    if(!isset($_GET['tokId'])){
        redirect('/cms');
    }


    if(ifItIsMethod('post')){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $tokLen = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($tokLen));
            if(email_exists($email)){
                if($stmt = mysqli_prepare($connection,"UPDATE users SET token ='{$token}' WHERE user_email = ?")){
                    mysqli_stmt_bind_param($stmt,'s',$email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    /*
                     * Config PHPmailer
                     *
                     * */
                    $mail = new PHPMailer();
                    try {
                        $mail->isSMTP();
                        $mail->Host = config::SMTP_HOST;
                        $mail->Username = config::SMTP_USER;
                        $mail->Password = config::SMTP_PASSWORD;
                        $mail->Port = config::SMTP_PORT;
                        $mail->SMTPSecure = 'ssl';
                        $mail->SMTPAuth = true;
                        $mail->CharSet = 'UTF-8';


                        //Recipients
                        $mail->setFrom('MyEmail', 'Ali Alaa');
                        $mail->addAddress($email);     //Add a recipient


                        //Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Finally Solved';
                        $mail->Body    = '<p>Please click to reset your password
                            <a href="http://localhost/cms/reset.php?email='.$email.'&token='.$token.'">http://localhost/cms/reset.php?email='.$email.'&token='.$token.'</a>
                        </p>
                        
                        ';

                        $mail->send();
                        $emailSend = true;
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }
                //echo  "<p style='width: 30%;margin: 10px auto;text-align: center;background-color: #f5c6cb;color: #721c24;'>This email not found</p>";

        }
    }
?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <?php if(!isset( $emailSend)): ?>


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                            <?php else: ?>
                                <h1 style='padding: 10px;text-align: center;background-color: #28a745;color: #fff;'>Please click the link in your email inbox to reset your password</h1>
                            <?php endIf; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

