<?php

    include_once('../../php/config/userDbConn.php');

    $database = new UserDbConn();

    $connection = $database->getConnection();

    $sqlQuery = '
        INSERT INTO
            users (FirstName, LastName, Password, Email)
        VALUES ("User2","Usersen2", :password, "user2@user2.com")


    ';

    $stmt = $connection->prepare($sqlQuery);

    $password = "password";
    $password = password_hash($password, PASSWORD_DEFAULT);

    //bind stuff
    $stmt->bindParam(':password', $password);

    $stmt->execute();
    $connection = null;

?>