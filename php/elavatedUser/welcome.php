<?php
    
    session_start();

    if(!isset($_SESSION['logInEU']) || $_SESSION['logInEU'] != true && is_csrf_valid()) {
        header("Location: login.php"); 
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
        <title>Document</title>
    </head>
    <body>
        <h1>Welcome <?php echo $_SESSION['FirstName']?></h1>

        <button class="EditAccount">Edit Account</button>
        <button class="AdministerUsers">Administer Users</button>
    </body>
</html>