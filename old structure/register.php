<?php
    if(!session_status()) {
        session_start();
        $_SESSION['logInNU']=FALSE;
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>

</head>
<body>
    <h1>Register User</h1>
    <form method="POST" action="php/anonUser/register_user.php">
        <?php set_csrf() ?>
        <label>Email: </label><br>
        <input type="text" name="email" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <label>Repeat Password: </label><br>
        <input type="password" name="password2" required><br>

        <label>Firstname: </label><br>
        <input type="text" name="firstname" required><br>

        <label>Lastname: </label><br>
        <input type="text" name="lastname" required><br>

        <button type="submit">Register</button><br>
    </form>
</body>
</html>