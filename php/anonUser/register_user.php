<?php
    //checking if username and password is postet
    if(isset($_POST['email']) && 
        isset($_POST['password']) &&
        isset($_POST['password2']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        $_POST['password'] == $_POST['password2'] &&
        checkEmail($_POST['email'])){

        //include dbconnection from anon souce.
        include_once('../config/guestDbConn.php');

        //gets login functions
        // echo $_POST['username'];
        //include_once('php/anonUser/login.php');
        include_once('generalFunctions/core.php');

        $database = new GuestDbConn();

        $emailExists = emailExists($_POST['email']);

        $password = $_POST['password'];
        $msg = "";
 
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
            $msg = "weak";
          } else {
            $msg = "strong";
          }

        if(!$emailExists && $msg == "strong") {
            registerUser($_POST);
            echo "Success, user created. Redirecting to login...";
            //header("refresh:3; url=../../index.php");
        }
        else {
            echo "Email already exists or you password is too weak!";
            //header( "refresh:5; url=../../register.php" );            
        }

    }
    else {
        echo "Fields missing or passwords dont match, please try again.";
        header( "refresh:5; url=../../register.php" );
    }

    function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
     }


?>