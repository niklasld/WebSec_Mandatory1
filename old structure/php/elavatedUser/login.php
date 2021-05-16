<?php
    session_start();
    $_SESSION['logInEU']=false;
    
    //checking if username and password is postet
    if(isset($_POST['username']) && isset($_POST['password']) && is_csrf_valid()){


        //gets login functions
        include_once('generalFunctions/core.php');

        //set post variables
        $email = $_POST['username'];
        $pwd = $_POST['password'];

        //call test()
        checkLogin($email, $pwd);
    }

    function set_csrf(){
        if(session_status() == 1){ session_start(); }
        $csrf_token = bin2hex(random_bytes(25));
        $_SESSION['csrf'] = $csrf_token;
        echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';
      }
      function is_csrf_valid(){
        if(session_status() == 1){ session_start(); }
        if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
        if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
        return true;
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
</head>
<body>
    <form method="POST" action="#">
        <?php set_csrf() ?>
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>