<?php
    session_start();

    // if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    //     header("Location: ../anonUser/login.php"); 
    // }

    if(isset($_POST['header']) && isset($_POST['content'])) {
        include_once('generalFunctions/updatePost.php');

        $success = updatePost($_POST);

        
        if($success == true) {
            header("Location: wallView.php"); 
            //echo $_POST;
        }
        else {
            echo "an error happened...";
        }
    }
    if(isset($_POST['WallPostIdUpdate'])) {
        include_once('generalFunctions/core.php');
        getWallpostById($_POST['WallPostIdUpdate']);
    }
    else {
        header("Location: wallView.php");
    }
?>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        <?php include_once('../../head.php'); ?>
    </style>
</head>
<body>
    <?php include_once('../../header.php'); ?>
    <form method="POST" action="#">
        <input type="hidden" name="wallPostId" value="<?php echo $_POST['WallPostIdUpdate'] ?>">
        <label>Header: </label><br>
        <input type="text" name="header" required><br>

        <label>Content: UpdatwWallpost</label><br>
        <textarea type="text" name="content" rows="10" cols="50" required></textarea><br>

        <label>Image link: </label><br>
        <input type="text" name="imgLink"><br>

        <!-- <input type="hidden" name="createdBy" value="<?php //echo $_SESSION['userId'] ?>"> -->

        <button type="submit">Update WallPost</button>
    </form>
    <?php 
        //include_once('./generalFunctions/core.php');
    ?>
</body>
</html> -->