<?php
    /////////////////////////////////////////////////////////
    //////////////////////CSFR!!!!///////////////////////////
    /////////////////////////////////////////////////////////
    // session_start();
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }

    if(!isset($_SESSION['logInNU']) || $_SESSION['logInNU'] != true) {
        header("Location: ../../"); 
    }

    if(isset($_POST['reply']) && isset($_POST['postId'])) {
        //include_once('generalFunctions/postReply.php');

        $success = replyToWallPost($_POST);
        echo $success;

        
        if($success == true) {
            header("Location:= ../../wallview"); 
            //echo $_POST;
        }
        else {
            echo "an error happened...";
        }
    }

    function replyToWallPost($postData) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

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