<?php
    function deletePost($wallPostId) {
        $allowed = checkForCorrectUser($wallPostId);
        if($allowed == true) {
            //delete post
            deletePostAllowed($wallPostId);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error now allowed';
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

    function deletePostAllowed($wallPostId) {
        if(isset($_SESSION['logInEU']) && $_SESSION['logInEU'] == true) {
            //include dbconnection from souce.
            include_once('../../php/config/euDbConn.php');

            //create database conn
            $database = new EuDbConn();

            //connect
            $connection = $database->getConnection();

            $sqlQuery = '
                DELETE FROM
                    wallposts
                WHERE
                    WallPostId=:WallPostId
            ';

            $stmt = $connection->prepare($sqlQuery);

            //sanitize
            $wallPostId = htmlspecialchars(strip_tags($wallPostId));

            //bind params
            $stmt->bindParam(':WallPostId', $wallPostId);

            //execute
            $stmt->execute();
        }
    }
?>