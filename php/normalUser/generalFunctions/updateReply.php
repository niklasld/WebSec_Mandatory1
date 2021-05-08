<?php
    function updateReply($replyId) {
        $allowed = checkForCorrectUser($replyId);
        if($allowed == true) {
            //update reply
            updatePostAllowed($replyId);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error, not allowed';
        }
    }

    function checkForCorrectUser($replyId) {
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
                postreply
            WHERE
                PostReplyId = :PostReplyId
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanitize
        $replyId = htmlspecialchars(strip_tags($replyId));

        //bind params
        $stmt->bindParam(':PostReplyId', $replyId);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['CreatedBy'] == $_SESSION['userId']) {
           return true; 
        }
        return false;
    }

    function updateReplyAllowed($replyId) {
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
            $replyId = htmlspecialchars(strip_tags($replyId));
            $postData['reply'] = htmlspecialchars(strip_tags($postData['reply']));

            //bind params
            $stmt->bindParam(':Reply', $postData['reply']);
            $stmt->bindParam(':PostReplyId', $replyId);

            //execute
            $stmt->execute();
        }
    }
?>