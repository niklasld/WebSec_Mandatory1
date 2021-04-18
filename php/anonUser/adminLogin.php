<?php
    session_start();
    $_SESSION['logInEU']=false;
    
    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password'])){


        //gets login functions
        include_once('generalFunctions/core.php');

        //set post variables
        $email = $_POST['username'];
        $pwd = $_POST['password'];

        //call test()
        checkLogin($email, $pwd);
    }

?>

<!DOCTYPE html>
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
</html>