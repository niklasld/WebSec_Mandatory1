<?php
    session_start();
    //echo $_SESSION['logInNU'];

    if(!isset($_SESSION['logInNU']) || $_SESSION['logInNU'] != TRUE) {
        //header("Location: ../../index.php"); 
        echo $_SESSION['logInNU'];
    }

    if(isset($_POST['WallPostIdDelete'])) {
        include_once('./generalFunctions/deletePost.php');
        deletePost($_POST['WallPostIdDelete']);
        $_POST = array();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        <?php include_once('../../head.php'); ?>
    </style>
</head>
<body>
    <?php include_once('../../header.php'); ?>
    <br><button class="createWallPost" type="submit">Create Wallpost</button>
    <script src="../../js/createWallPost.js"></script>

    <?php 
        include_once('./generalFunctions/core.php');
        getWallPosts();
    ?>
    <script src="../../js/createWallPost.js"></script>
</body>
</html>