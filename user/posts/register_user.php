<?php
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }

    //checking if username and password is postet
    if(isset($_POST['email']) && 
        isset($_POST['password']) &&
        isset($_POST['password2']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        $_POST['password'] == $_POST['password2'] &&
        checkEmail($_POST['email'])){

        //include dbconnection from anon souce.
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/guestDbConn.php');

        //gets login functions
        // echo $_POST['username'];
        //include_once('php/anonUser/login.php');
        //include_once('generalFunctions/core.php');

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
            header("refresh:3; url=../../");
        }
        else {
            echo "Email already exists or you password is too weak!";
            header( "refresh:5; url=../../registerUser" );            
        }

    }
    else {
        echo "Fields missing or passwords dont match, please try again.";
        header( "refresh:5; url=../../registerUser" );
    }

    function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
     }

     
    function registerUser($userData) {
        
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

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

    
    function emailExists($email) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        //include dbconnection from anon souce.
        include_once($path.'/user/config/GuestDbConn.php');


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


?>