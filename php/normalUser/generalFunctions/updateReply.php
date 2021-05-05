<?php
    function updatePost($PostReplyId) {
        $allowed = checkForCorrectUser($PostReplyId);
        if($allowed == true) {
            //update reply
            updatePostAllowed($PostReplyId);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error, not allowed';
        }
    }

    function checkForCorrectUser($PostReplyId) {
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
                PostReplyId
            WHERE
                PostReplyId = :PostReplyId
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanitize
        $wallPostId = htmlspecialchars(strip_tags($PostReplyId));

        //bind params
        $stmt->bindParam(':WallPostId', $PostReplyId);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['CreatedBy'] == $_SESSION['userId']) {
           return true; 
        }
        return false;
    }

    function updatePostAllowed($PostReplyId) {
        if(isset($_SESSION['logInNU']) && $_SESSION['logInNU'] == true) {
            //include dbconnection from souce.
            include_once('../../php/config/userDbConn.php');

            //create database conn
            $database = new UserDbConn();

            //connect
            $connection = $database->getConnection();

            $sqlQuery = 'UPDATE postreply SET reply=:reply WHERE PostReplyId=:PostReplyId;';

            $stmt = $connection->prepare($sqlQuery);

            //sanitize
            $PostReplyId = htmlspecialchars(strip_tags($PostReplyId));
            $postData['reply'] = htmlspecialchars(strip_tags($postData['reply']));

            //bind params
            $stmt->bindParam(':Reply', $postData['reply']);
            $stmt->bindParam(':PostReplyId', $PostReplyId);

            //execute
            $stmt->execute();
        }
    }
?>