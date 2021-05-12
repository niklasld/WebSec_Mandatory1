<?php
    if(!session_status()) {
        session_start();
        $_SESSION['logInNU']=FALSE;
    }
    echo $_POST['username'];
    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password']) && is_csrf_valid()){


        //gets login functions
        include_once('generalFunctions/core.php');

        //set post variables
        echo $_POST['username'];
        $email = $_POST['username'];
        $pwd = $_POST['password'];

        //call test()
        echo "hello";
        checkLogin($email, $pwd);
    }

    function is_csrf_valid(){
        if(session_status() == 1){ session_start(); }
        if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
        if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
        return true;
    }

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Login</title>
</head>
<body>
    <form method="POST" action="#">
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html> -->