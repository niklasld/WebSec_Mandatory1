<?php

    include_once('../../php/config/guestDbConn.php');

    $database = new GuestDbConn();

    $connection = $database->getConnection();

    $sqlQuery = '
        INSERT INTO
            users (FirstName, LastName, Password, Email)
        VALUES ("User","Usersen", :password, "user@user.com")


    ';

    $stmt = $connection->prepare($sqlQuery);

    $password = "password";
    $password = password_hash($password, PASSWORD_DEFAULT);

    //bind stuff
    $stmt->bindParam(':password', $password);

    $stmt->execute();
    $connection = null;

?>