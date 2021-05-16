<?php
    session_start();
    function checkLogin($email, $pwd) {

        //find user in Database.
        $user = findUserByUserName($email);

        if(isset($user['LastLogin']) && is_csrf_valid()) {
            //check if user is validated.
            $validate = checkUser($user, $pwd);

            if($validate == "Success") {
                header("Location: ../../php/normalUser/wallView.php"); 
            }
            else {
                echo "<br>";
                echo $validate;
                header("refresh:3; url=../../index.php");
            }
        } 
        else {
            echo "invalid_user";
            exit();
        }

    }

    function is_csrf_valid(){
        if(session_status() == 1){ session_start(); }
        if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
        if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
        return true;
    }

    function checkLoginAdmin($email, $pwd) {
        //find user in Database.
        $user = findAdminByUsername($email);

        //check if user is validated.
        $validate = check($user, $pwd);

        if($validate == "Success") {
            header("Location: ../elavatedUser/wallView.php"); 
        }
        else {
            echo $validate;
        }
    }

    function checkAdminUser($user, $pwd) {
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
                $_SESSION['logInEU'] = true;
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

        echo $attempts." ".$currentTime." ".$email;

        //bind paramiters
        $stmt->bindParam(':LastLogin', $currentTime);
        $stmt->bindParam(':LoginAttempts', $attempts);
        $stmt->bindParam(':Email', $email);

        $stmt->execute();
    }

    function findUserByUserName($email) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        //include dbconnection from anon souce.
        include_once($path.'/php/config/GuestDbConn.php');

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

    function findAdminByUsername($email) {
        //include dbconnection from anon souce.
        include_once('config/euDbConn.php');

        //create database conn
        $database = new euDbConn();

        //connect
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT 
                *
            FROM
                elavatedusers
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

    function emailExists($email) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        //include dbconnection from anon souce.
        include_once($path.'/php/config/GuestDbConn.php');


        //create database conn
        $database = new GuestDbConn();

        //connect
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT 
                Email
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

        if(isset($data['Email'])) {
            return true;
        }
        else {
            return false;
        }


    }

    function registerUser($userData) {
        
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            INSERT INTO
                users (FirstName, LastName, Password, Email)
            VALUES (:firstname, :lastname, :password, :email)
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanatize
        $userData['email'] = htmlspecialchars(strip_tags($userData['email']));
        $userData['firstname'] = htmlspecialchars(strip_tags($userData['firstname']));
        $userData['lastname'] = htmlspecialchars(strip_tags($userData['lastname']));

        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

        //var_dump($userData);
        //bind stuff
        $stmt->bindParam(':email', $userData['email']);
        $stmt->bindParam(':password', $userData['password']);
        $stmt->bindParam(':firstname', $userData['firstname']);
        $stmt->bindParam(':lastname', $userData['lastname']);
        //var_dump($stmt);
        $stmt->execute();
        $connection = null;

    }

?>