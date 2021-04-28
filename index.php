<?php
    session_start();
    $_SESSION['logInNU']=false;
    
    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password'])){
        //include dbconnection from anon souce.
        include_once('php/config/guestDbConn.php');

        //gets login functions
        include_once('php/anonUser/login.php');

        $database = new Database();

        $usrName = $_POST['username'];
        $pwd = $_POST['password'];

        //do something
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>User Login</h1>
    <form method="POST" action="#">
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>