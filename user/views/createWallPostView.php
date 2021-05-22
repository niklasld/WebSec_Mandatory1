<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Wall Post</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        <?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/views/fragments/head.php'); ?>
    </style>
</head>
<body>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/user/views/fragments/header.php'); ?>
    <div class="content">
        <h1>Create post</h1>
        <form method="POST" action="../../createWallPost">
            <?php set_csrf() ?>
            <label>Header: </label><br>
            <input type="text" name="header" required><br>

            <label>Content: </label><br>
            <textarea type="text" name="content" rows="10" cols="50" required></textarea><br>
<!-- 
            <label>Image link: </label><br>
            <input type="text" name="imgLink"><br> -->

            
            <label>File(PNG or JPG):</label><br>
            <input type="file" name="file"><br>

            <!-- <input type="hidden" name="createdBy" value="<?php //echo $_SESSION['userId'] ?>"> -->

            <button type="submit">Create WallPost</button>
        </form>
        <?php 
            //include_once('./generalFunctions/core.php');
        ?>
    </div>
</body>
</html>