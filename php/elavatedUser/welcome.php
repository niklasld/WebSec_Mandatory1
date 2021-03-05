<?php
    
    session_start();

    if(!isset($_SESSION['logInEU']) || $_SESSION['logInEU'] != true) {
        header("Location: login.php"); 
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