<?php
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }

    if(!isset($_SESSION['logInEU']) || $_SESSION['logInEU'] != TRUE) {
        //header("Location: ../../index.php"); 
        out($_SESSION['logInEU']);
    }

    if(isset($_POST['WallPostIdDelete'])) {
        //include_once('./generalFunctions/deletePost.php');
        deletePost($_POST['WallPostIdDelete']);
        $_POST = array();
    }

    function deletePost($wallPostId) {
        $allowed = checkForCorrectUser($wallPostId);
        if($allowed == true || $_SESSION['logInEU'] == TRUE) {
            //delete post
            deletePostAllowed($wallPostId);

            //redirect
            header("Location: ../../wallviewAdmin"); 
        } else {
            out('Error not allowed');
        }
    }

    function checkForCorrectUser($wallPostId) {
        //include dbconnection from souce.
        include_once($_SERVER['DOCUMENT_ROOT'].'/elavatedUser/config/euDbConn.php');

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

        if($data['CreatedBy'] == $_SESSION['userId']) {
           return true; 
        }
        return false;
    }

    function deletePostAllowed($wallPostId) {
        if(isset($_SESSION['logInEU']) && $_SESSION['logInEU'] == true) {
            //include dbconnection from souce.
            include_once($_SERVER['DOCUMENT_ROOT'].'/elavatedUser/config/euDbConn.php');

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