<?php
    session_start();

    // if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    //     header("Location: ../anonUser/login.php"); 
    // }

    if(isset($_POST['header']) && isset($_POST['content'])) {
        echo $_POST['header'];
        echo $_POST['content'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="#">
        <label>Header: </label><br>
        <input type="text" name="header" required><br>

        <label>Content: </label><br>
        <textarea type="text" name="content" rows="10" cols="50" required></textarea><br>

        <label>Image link: </label><br>
        <input type="text" name="imgLink"><br>

        <!-- <input type="hidden" name="createdBy" value="<?php //echo $_SESSION['userId'] ?>"> -->

        <button type="submit">Create WallPost</button>
    </form>
    <?php 
        //include_once('./generalFunctions/core.php');
    ?>
</body>
</html>