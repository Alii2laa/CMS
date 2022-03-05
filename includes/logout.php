<?php session_start();?>
<?php include "db.php";?>
<?php

    $session = session_id();
    $query = "DELETE FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection,$query);

    $_SESSION['$userName'] = null;
    $_SESSION['user_firstname'] = null;
    $_SESSION['user_lastname'] = null;
    $_SESSION['user_role'] = null;
    header("Location: /cms");
?>