<?php
    session_start();

    // if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    //     header("Location: ../anonUser/login.php"); 
    // }

    if(isset($_POST['reply']) && isset($_POST['postReplyId'])) {
        include_once('generalFunctions/updateReply.php');

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
        getWallpostById($_POST['ReplyUpdate']);
    }
    else {
        echo "nothing hit";
        //header("Location: wallView.php");
    }
?>