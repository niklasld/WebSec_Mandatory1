<?php
    function updateReply($reply) {
        $allowed = checkForCorrectUser($reply['postReplyId']);
        if($allowed == true) {
            //update reply
            updateReplyAllowed($reply);

            //redirect
            header("Location: wallView.php"); 
        } else {
            echo 'Error, not allowed';
        }
    }

    function is_csrf_valid(){
        if(session_status() == 1){ session_start(); }
        if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
        if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
        return true;
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

    function updateReplyAllowed($postData) {
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
            $postData['postReplyId'] = htmlspecialchars(strip_tags($postData['postReplyId']));
            $postData['reply'] = htmlspecialchars(strip_tags($postData['reply']));

            //bind params
            $stmt->bindParam(':reply', $postData['reply']);
            $stmt->bindParam(':PostReplyId', $postData['postReplyId']);

            //execute
            $stmt->execute();
        }
    }
?>