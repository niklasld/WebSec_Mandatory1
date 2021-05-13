<?php
    session_start();

    // if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true) {
    //     header("Location: ../anonUser/login.php"); 
    // }
    if(isset($_POST['reply']) && isset($_POST['postReplyId'])) {
        include_once('generalFunctions/updateReply.php');
        //var_dump($_POST);
        $success = updateReply($_POST);
        
        
        // if($success == true) {
        //     header("Location: wallView.php"); 
        //     //echo $_POST;
        // }
        // else {
        //     echo "an error happened...";
        // }
    }
    if(isset($_POST['ReplyUpdate'])) {
        include_once('generalFunctions/core.php');
        printUpdateReplies($_POST['ReplyUpdate']);
    }
    else {
        echo "nothing hit";
        //header("Location: wallView.php");
    }

?>