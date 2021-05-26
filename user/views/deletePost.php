<?php
    if(!isset($_SESSION['logInNU']) || $_SESSION['logInNU'] != TRUE) {
        //header("Location: ../../index.php"); 
        out($_SESSION['logInNU']);
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Wall Post</title>
    <link rel="stylesheet" href="../../css/styles.css">

    <style>
        <?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/views/fragments/head.php'); ?>
    </style>

</head>
<body>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/views/fragments/header.php'); ?>
    <div class="content">
        <form method="POST" action="../../deletePostConfirmed">
            <?php set_csrf() ?>
            <input type="hidden" name="WallPostIdDelete" value="<?php out($_POST['WallPostIdDelete']);?>">           
            <h1>Are you sure you wish to delete the wallpost??</h1>

            <!-- <input type="hidden" name="createdBy" value="<?php //echo $_SESSION['userId'] ?>"> -->

            <button type="submit">Confirm</button>
        </form>
        <?php 
            //include_once('./generalFunctions/core.php');
        ?>
    </div>
</body>
</html>
