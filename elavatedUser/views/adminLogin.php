<?php
    if(!session_status()) {
        session_start();
        $_SESSION['logInEU']=FALSE;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin Login</title>

</head>
<body>
    <h1>Admin Login</h1>
    <form method="POST" action="/adminLogin">
        <?php set_csrf() ?>
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login </button><br>
    </form>
</body>
</html>