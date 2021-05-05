<?php
    function updatePost($wallPostId) {
        $allowed = checkForCorrectUser($wallPostId);
        if($allowed == true) {
            //update post
            updatePostAllowed($wallPostId);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error, not allowed';
        }
    }

    function checkForCorrectUser($wallPostId) {
        //include dbconnection from souce.
        include_once('../../php/config/userDbConn.php');

        //create database conn
        $database = new UserDbConn();

        //connect
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                *
            FROM
                wallposts
            WHERE
                WallPostId = :WallPostId
        ';

        $stmt = $connection->prepare($sqlQuery);

        var_dump($wallPostId);
        //sanitize
        $wallPostId = htmlspecialchars(strip_tags($wallPostId));

        //bind params
        $stmt->bindParam(':WallPostId', $wallPostId);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['CreatedBy'] == $_SESSION['userId']) {
           return true; 
        }
        return false;
    }

    function updatePostAllowed($wallPostId) {
        if(isset($_SESSION['logInNU']) && $_SESSION['logInNU'] == true) {
            //include dbconnection from souce.
            include_once('../../php/config/userDbConn.php');

            //create database conn
            $database = new UserDbConn();

            //connect
            $connection = $database->getConnection();

            $sqlQuery = 'UPDATE wallposts SET Header=:Header, Content=:Content, FileLink=:FileLink WHERE WallPostId=:WallPostId;';

            $stmt = $connection->prepare($sqlQuery);

            //sanitize
            $wallPostId = htmlspecialchars(strip_tags($wallPostId));
            $postData['header'] = htmlspecialchars(strip_tags($postData['header']));
            $postData['content'] = htmlspecialchars(strip_tags($postData['content']));
            if(isset($postData['imgLink'])){
                $postData['imgLink'] = htmlspecialchars(strip_tags($postData['imgLink']));
            }

            //bind params
            $stmt->bindParam(':WallPostId', $wallPostId);
            $stmt->bindParam(':Header', $postData['header']);
            $stmt->bindParam(':Content', $postData['content']);
            if(isset($postData['imgLink'])) {
                $stmt->bindParam(':FileLink', $postData['imgLink']);
            } else {
                $stmt->bindParam(':FileLink', "");
            }

            //execute
            $stmt->execute();
        }
    }
?>