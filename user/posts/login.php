<?php
    // if(!session_status()) {
    //     session_start();
    //     $_SESSION['logInNU']=FALSE;
    // }
    // echo session_status();
    // session_start();
    out($_SESSION['logInNU']);
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }

    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password'])){
        //include dbconnection from anon souce.
        $root = $_SERVER['DOCUMENT_ROOT'];
        include_once($root.'/user/config/guestDbConn.php');

        //gets login functions
        // echo $_POST['username'];
        //include_once('php/anonUser/login.php');
        //include_once('generalFunctions/core.php');

        $database = new GuestDbConn();

        $email = $_POST['username'];
        $pwd = $_POST['password'];

        checkLogin($email, $pwd);
    }

    function checkLogin($email, $pwd) {

        //find user in Database.
        $user = findUserByUserName($email);

        if(isset($user['LastLogin'])) {
            //check if user is validated.
            $validate = checkUser($user, $pwd);

            if($validate == "Success") {
                // echo $_SESSION['logInNU'];
                // echo $_SESSION['userId'];
                // echo $_SESSION['FirstName'];
                header("Location: ".$root."/wallview"); 
            }
            else {
                echo "<br>";
                out($validate);
                header("refresh:3; url=../../index.php");
            }
        } 
        else {
            echo "invalid_user";
            exit();
        }

    }

    function checkUser($user, $pwd) {

        //time data

        //set loggedTime variable DateTime based on database laslogin
        $loggedTime = new DateTime($user['LastLogin']);
        //add 5 min to the time in the database time
        $loggedTime->add(new DateInterval('PT' . 5 . 'M'));

        //set currentTime variable based on current time
        $currentTime = new DateTime(date('Y-m-d H:i:s'));

        //set datatime format
        $loggedTime = $loggedTime->format('Y-m-d H:i:s');
        $currentTime = $currentTime->format('Y-m-d H:i:s');
        
        //checks if login attems is larger or equals 3 or if loggedtime is less than or equal to current time
        if($user['LoginAttempts']+1<=3 || $loggedTime <= $currentTime) {
            //check for password match
            if(password_verify($pwd, $user['Password'])) {
                //set sessions data and return true
                $_SESSION['logInNU'] = TRUE;
                $_SESSION['userId'] = $user['UserId'];
                $_SESSION['FirstName'] = $user['FirstName'];
                return "Success";
            } 
            //update database with a failed login (set attempts +1, and update last login)
            else {
                //set session data
                $_SESSION['logInEU'] = false;

                //call update failed login function to update data.
                updateFailedLogin($user, $currentTime);
                return "Login Failed...";
            }
        }
        else {
            return "Account have been locked...";
        }
    }

    function updateFailedLogin($user, $currentTime) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        //include dbconnection from anon souce.
        include_once($path.'/php/config/GuestDbConn.php');

        //create database conn
        $database = new GuestDbConn();

        //connect
        $connection = $database->getConnection();

        $sqlQuery = '
            UPDATE
                users
            SET 
                LastLogin=:LastLogin,
                LoginAttempts=:LoginAttempts
            WHERE
                Email=:Email
        ';

        $stmt = $connection->prepare($sqlQuery);

        $attempts = $user['LoginAttempts']+1;
        $email = $user['Email'];

        out($attempts." ".$currentTime." ".$email);

        //bind paramiters
        $stmt->bindParam(':LastLogin', $currentTime);
        $stmt->bindParam(':LoginAttempts', $attempts);
        $stmt->bindParam(':Email', $email);

        $stmt->execute();
    }

    function findUserByUserName($email) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        //include dbconnection from anon souce.
        include_once($path.'/user/config/GuestDbConn.php');

        //create database conn
        $database = new GuestDbConn();

        //connect
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT 
                *
            FROM
                users
            WHERE
                Email =:Email
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanatize
        $email = htmlspecialchars(strip_tags($email));

        //bind stuff
        $stmt->bindParam(':Email', $email);

        $stmt->execute();
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
?>