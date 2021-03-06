<?php

    function checkLogin($email, $pwd) {

        //find user in Database.
        $user = findUserByUserName($email);

        //check if user is validated.
        $validate = checkUser($user, $pwd);

        if($validate == "Success") {
            header("Location: ../normalUser/wallView.php"); 
        }
        else {
            echo $validate;
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
                $_SESSION['logInNU'] = true;
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
        //include dbconnection from anon souce.
        include_once('../../php/config/GuestDbConn.php');

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

        echo $attempts." ".$currentTime." ".$email;

        //bind paramiters
        $stmt->bindParam(':LastLogin', $currentTime);
        $stmt->bindParam(':LoginAttempts', $attempts);
        $stmt->bindParam(':Email', $email);

        $stmt->execute();
    }

    function findUserByUserName($email) {
        //include dbconnection from anon souce.
        include_once('../../php/config/GuestDbConn.php');

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