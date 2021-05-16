<?php
    session_start();

    // if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    //     header("Location: ../anonUser/login.php"); 
    // }

    if(isset($_POST['header']) && isset($_POST['content']) && isset($_POST['wallPostId'])) {
        include_once('generalFunctions/updatePost.php');

        $success = updatePost($_POST);
        var_dump($_POST);
        
        // if($success == true) {
        //     header("Location: wallView.php"); 
        //     //echo $_POST;
        // }
        // else {
        //     echo "an error happened...";
        // }
    }
    if(isset($_POST['WallPostIdUpdate'])) {
        include_once('generalFunctions/core.php');
        getWallpostById($_POST['WallPostIdUpdate']);
    }
    else {
        echo "nothing hit";
        //header("Location: wallView.php");
    }
?>