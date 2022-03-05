<?php

    function redirect($location){

        header("Location:" . $location);
        exit;

    }

function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function isLoggedIn(){

    if(isset($_SESSION['user_role'])){

        return true;
    }
    return false;

}

function loggedInUserId(){
        global $connection;
        if(isLoggedIn()){
            $result = mysqli_query($connection,"SELECT * FROM users WHERE user_name='".$_SESSION['userName']."'");
            $user = mysqli_fetch_array($result);
            return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;

        }
        return false;
}

function userLikedPosts($post_id){
    global $connection;
    $result =  mysqli_query($connection,"SELECT * FROM likes WHERE user_id =" .loggedInUserId() . " AND post_id={$post_id}");
    if($result)
        return mysqli_num_rows($result) >= 1 ? true : false;

}

function getPostLikes($post_id){
    global $connection;
    $result =  mysqli_query($connection,"SELECT * FROM likes WHERE post_id = {$post_id}");
    if($result)
        echo mysqli_num_rows($result);
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

    if(isLoggedIn()){

        redirect($redirectLocation);
    }

}

    function escapeSqlInj($string){
        global $connection;
        return mysqli_real_escape_string($connection,trim($string));
    }



    function user_online(){
        global $connection;
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 60;
        global $time_out;
        $time_out = $time - $time_out_in_seconds;
        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection,$query);
        $count = mysqli_num_rows($send_query);

        if($count == NULL &&  $_SESSION['userName']){
            mysqli_query($connection,"INSERT INTO users_online(session, time) VALUES('$session','$time')");
        }else{
            mysqli_query($connection,"UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }
    }

    function AddNewCatogery(){
        global $connection;
        if (isset($_POST['cat_submit'])) {
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $cat_title = escapeSqlInj($_POST['cat_title']);
                    if ($cat_title == "" || empty($cat_title)) {
                        echo "<mark style='background-color:#f8d7da;color:#842029;display: inline-block;margin-bottom: 10px'>This Field Should Not Be Empty</mark>";
                    } else {
                        $stmt = mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUE (?)");
                        mysqli_stmt_bind_param($stmt,'s',$cat_title);
                        mysqli_stmt_execute($stmt);
                        if (!$stmt) {
                            die("Not Added please try" . mysqli_error($connection));
                        }
                    }
                }
            }



        }
    }
    function DeleteCategory(){
        //Delete category
        global $connection;
        if(isset($_GET['delete'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_cat_id = escapeSqlInj($_GET['delete']);
                    $query = "DELETE FROM categories WHERE cat_id ={$the_cat_id}";
                    $delete_cat_query = mysqli_query($connection,$query);
                    header("Location: categories.php");
                }
            }

        }
    }



    function recordCount($table){
        global $connection;
        $query = "SELECT * FROM " . $table;
        $select = mysqli_query($connection,$query);
        $result = mysqli_num_rows($select);

        return $result;

    }

    function checkStatus($table, $column,$status){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $select = mysqli_query($connection,$query);
        $result = mysqli_num_rows($select);

        return $result;
    }
    function checkRole($table, $column,$role){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column != '$role'";
        $select = mysqli_query($connection,$query);
        $result = mysqli_num_rows($select);

        return $result;
    }



    function changeRole($role,$userId){
        global $connection;
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                $query = "UPDATE users SET user_role = '$role' WHERE user_id = {$userId}";
                $admin_query = mysqli_query($connection,$query);
                header("Location: users.php");

            }
        }


    }



    function username_exists($username){
        global $connection;
        $query = "SELECT user_name FROM users WHERE user_name = '$username'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("Not Added please try" . mysqli_error($connection));
        }


        if(mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }

    }

function email_exists($email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("please try" . mysqli_error($connection));
    }


    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }

}

function is_admin($username) {

    global $connection;

    $query = "SELECT user_role FROM users WHERE user_name = '$username'";
    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_array($result);


    if($row['user_role'] == 'admin'){

        return true;

    }else {
        return false;
    }

}


function register_user($username,$email,$password){
        global $connection;
        global $msg;
        $username   = mysqli_real_escape_string($connection,$_POST['username']);
        $email      = mysqli_real_escape_string($connection,$_POST['email']);
        $password   = mysqli_real_escape_string($connection,$_POST['password']);

        $password = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12));

        $query  = "INSERT INTO users (user_name,user_password,user_email,user_role) ";
        $query .= " VALUES('{$username}','{$password}','{$email}', 'user')";
        $register_user_query = mysqli_query($connection,$query);
        if(!$register_user_query){
            die("Query Filed" . mysqli_error($connection));
        }

}


function login_user($userName,$userPassword){
    global $connection;

    $userName =  mysqli_real_escape_string($connection,$_POST['username']);
    $userPassword =  mysqli_real_escape_string($connection,$_POST['password']);

    $query = "SELECT * FROM users WHERE user_name = '{$userName}'";
    $select_user = mysqli_query($connection,$query);

    if(!$select_user){
        die("Query Failed" . " " . mysqli_error($connection));
    }

    if($select_user){
        while ($row = mysqli_fetch_assoc($select_user)){
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role = $row['user_role'];

            if(password_verify($userPassword, $user_password)){
                $_SESSION['user_id'] = $user_id;
                $_SESSION['userName'] = $user_name;
                $_SESSION['user_firstname'] = $user_firstname;
                $_SESSION['user_lastname'] = $user_lastname;
                $_SESSION['user_role'] = $user_role;
                user_online();
            }else{
                return false;
            }

        }
        return true;
    }
}




?>