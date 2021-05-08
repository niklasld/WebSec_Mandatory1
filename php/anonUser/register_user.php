<?php
    //checking if username and password is postet
    if(isset($_POST['email']) && 
        isset($_POST['password']) &&
        isset($_POST['password2']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        $_POST['password'] == $_POST['password2']){

        //include dbconnection from anon souce.
        include_once('../config/guestDbConn.php');

        //gets login functions
        // echo $_POST['username'];
        //include_once('php/anonUser/login.php');
        include_once('generalFunctions/core.php');

        $database = new GuestDbConn();

        $emailExists = emailExists($_POST['email']);

        if(!$emailExists) {
            registerUser($_POST);
            echo "Success, user created. Redirecting to login...";
            header("refresh:3; url=../../index.php");
        }
        else {
            echo "Email already exists..";
            header( "refresh:5; url=../../register.php" );            
        }

    }
    else {
        echo "Fields missing or passwords dont match, please try again.";
        header( "refresh:5; url=../../register.php" );
    }


?>