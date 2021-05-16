<?php
    // session_start();

    function replyToWallPost($postData) {
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            INSERT INTO
                postreply (
                    Reply,
                    CreatedBy,
                    WallId
                )
            VALUES (
                :Reply, 
                :CreatedBy,
                :WallId
            )
        ';

        $stmt = $connection->prepare($sqlQuery);

        var_dump($postData);
        //sanitize
        $postData['reply'] = htmlspecialchars(strip_tags($postData['reply']));
        $postData['CreatedBy'] = htmlspecialchars(strip_tags($_SESSION['userId']));
        $postData['postId'] = htmlspecialchars(strip_tags($postData['postId']));

        //bind data
        $stmt->bindParam(':Reply', $postData['reply']);
        $stmt->bindParam(':CreatedBy', $postData['CreatedBy']);
        $stmt->bindParam(':WallId', $postData['postId']);

        var_dump($stmt);
        try {
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    } 
?>