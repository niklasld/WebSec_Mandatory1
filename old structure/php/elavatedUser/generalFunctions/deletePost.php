<?php
    function deletePost($wallPostId) {
        $allowed = checkForCorrectUser($wallPostId);
        if($allowed == true) {
            //delete post
            deletePostAllowed($wallPostId);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error not allowed';
        }
    }

    function checkForCorrectUser($wallPostId) {
        //include dbconnection from souce.
        include_once('../../php/config/euDbConn.php');

        //create database conn
        $database = new EuDbConn();

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

        if(isset($_SESSION['logInEU']) && $_SESSION['logInEU'] == TRUE) {
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