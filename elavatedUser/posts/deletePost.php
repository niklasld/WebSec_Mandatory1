<?php
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }
    
    /////////////////////////////////////////////////////////
    //////////////////////CSFR!!!!///////////////////////////
    /////////////////////////////////////////////////////////

    if(!isset($_SESSION['logInNU']) || $_SESSION['logInNU'] != TRUE) {
        //header("Location: ../../index.php"); 
        echo $_SESSION['logInNU'];
    }

    if(isset($_POST['WallPostIdDelete'])) {
        //include_once('./generalFunctions/deletePost.php');
        deletePost($_POST['WallPostIdDelete']);
        $_POST = array();
    }

    function deletePost($wallPostId) {
        $allowed = checkForCorrectUser($wallPostId);
        if($allowed == true) {
            //delete post
            deletePostAllowed($wallPostId);

            //redirect
            header("Location: ../../wallview"); 
        } else {
            echo 'Error now allowed';
        }
    }

    function checkForCorrectUser($wallPostId) {
        //include dbconnection from souce.
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

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
        if(isset($_SESSION['logInNU']) && $_SESSION['logInNU'] == true) {
            //include dbconnection from souce.
            include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

            //create database conn
            $database = new UserDbConn();

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