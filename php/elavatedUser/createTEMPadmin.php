<?php

    include_once('../../php/config/euDbConn.php');

    $database = new EuDbConn();

    $connection = $database->getConnection();

    $sqlQuery = '
        INSERT INTO
            elavatedusers (FirstName, LastName, Password, Email)
        VALUES ("Admin","Adminsen", :password, "Admin@Admin.com")


    ';

    $stmt = $connection->prepare($sqlQuery);

    $password = "password";
    $password = password_hash($password, PASSWORD_DEFAULT);

    //bind stuff
    $stmt->bindParam(':password', $password);

    $stmt->execute();
    $connection = null;

?>