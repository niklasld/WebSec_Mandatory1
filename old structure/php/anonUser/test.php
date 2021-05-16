<?php
    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password'])){
        //include dbconnection from anon souce.
        include_once('../config/guestDbConn.php');

        //gets login functions
        // echo $_POST['username'];
        //include_once('php/anonUser/login.php');
        include_once('generalFunctions/core.php');

        $database = new GuestDbConn();

        $email = $_POST['username'];
        $pwd = $_POST['password'];

        checkLogin($email, $pwd);

        //do something
    }


?>