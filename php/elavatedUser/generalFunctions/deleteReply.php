<?php

session_start();

if(isset($_POST['ReplyDelete'])) {
    deletePost($_POST['ReplyDelete']);
    header('Location: ../wallView.php'); 
}

function deletePost($postReplyId) {
        if(isset($_SESSION['logInEU']) && $_SESSION['logInEU'] == true) {
            echo $_POST['ReplyDelete'];
            //include dbconnection from souce.
            include_once($_SERVER['DOCUMENT_ROOT'].'/php/config/euDbConn.php');

            //create database conn
            $database = new EuDbConn();

            //connect
            $connection = $database->getConnection();

            $sqlQuery = '
                DELETE FROM
                    postreply
                WHERE
                    PostReplyId=:PostReplyId
            ';

            $stmt = $connection->prepare($sqlQuery);

            //sanitize
            $postReplyId = htmlspecialchars(strip_tags($postReplyId));

            //bind params
            $stmt->bindParam(':PostReplyId', $postReplyId);

            //execute
            $stmt->execute();
        }
    }
?>