<?php

    session_start();

    if(!isset($_SESSION['logInEU']) || $_SESSION['logInEU'] != true) {
        header("Location: ../elavatedUser/login.php"); 
    }

    if(isset($_POST['WallPostIdDelete'])) {
        include_once('./generalFunctions/deletePost.php');
        deletePost($_POST['WallPostIdDelete']);
        $_POST = array();
    }

    function is_csrf_valid(){
        if(session_status() == 1){ session_start(); }
        if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
        if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
        return true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <?php include_once('../../headerAdmin.php'); ?>
        <div class="content">
        <!-- <script src="../../js/createWallPost.js"></script> -->

        <?php 
            include_once('./generalFunctions/viewWallPosts.php');
            getWallPosts();
        ?>
    </div>
    <script src="../../js/createWallPost.js"></script>
</body>
</html>