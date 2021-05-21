<?php
    if(!session_status()) {
        session_start();
        $_SESSION['logInEU']=FALSE;
    }
    
    //checking if username and password is postet
    // if(isset($_POST['username']) && isset($_POST['password'])){
    //     //include dbconnection from anon souce.
    //     include_once('php/config/euDbConn.php');

    //     //gets login functions
    //     include_once('php/anonUser/adminLogin.php');

    //     $database = new EuDbConn();

    //     $usrName = $_POST['username'];
    //     $pwd = $_POST['password'];

    // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form method="POST" action="../postAdminLogin">
        <?php set_csrf() ?>
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>