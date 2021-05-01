<?php

    include_once('../../php/config/userDbConn.php');

    $database = new UserDbConn();

    $connection = $database->getConnection();

    $sqlQuery = '
        INSERT INTO
            users (FirstName, LastName, Password, Email)
        VALUES ("Peter","Panter", :password, "PP@Gmail.com")


    ';

    $stmt = $connection->prepare($sqlQuery);

    $password = "Herssu15k";
    $password = password_hash($password, PASSWORD_DEFAULT);

    //bind stuff
    $stmt->bindParam(':password', $password);

    $stmt->execute();
    $connection = null;

?>