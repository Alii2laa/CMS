<?php ob_start();?>
<?php include "../includes/db.php";?>
<?php include_once "functions.php";?>
<?php session_start();?>


<?php
    if(!isset($_SESSION['user_role'])){
        header("Location: ../error403.php");
    }else{
        if($_SESSION['user_role'] == 'user'){
            header("Location: ../error403.php");
        }
    }
    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                $user_id =  $_GET['delete'];
                if($_SESSION['user_id'] == $user_id){
                    $_SESSION['$userName'] = null;
                    $_SESSION['user_firstname'] = null;
                    $_SESSION['user_lastname'] = null;
                    $_SESSION['user_role'] = null;
                }
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.2/dist/css/bootstrap.min.css" integrity="sha384-Tfj13fqQQqqzQFuaZ81WDzmmOU610WeS08VMuHmElK5oI2f7NwojuL6VupYXR/jK" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="css/styles.css" rel="stylesheet">


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>


    <script src="js/jquery.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>





</head>

<body>