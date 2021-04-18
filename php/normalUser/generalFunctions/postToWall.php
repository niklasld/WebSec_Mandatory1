<?php
    function createWallPost($postData) {
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            INSERT INTO
                wallposts (
                    Header,
                    Content,
                    FileLink,
                    CreatedBy
                )
            VALUES (
                :Header, 
                :Content,
                :FileLink,
                :CreatedBy
            )
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanitize
        $postData['header'] = htmlspecialchars(strip_tags($postData['header']));
        $postData['content'] = htmlspecialchars(strip_tags($postData['content']));
        
        if(isset($postData['imgLink'])){
            $postData['imgLink'] = htmlspecialchars(strip_tags($postData['imgLink']));
        }

        $postData['createdBy'] = $_SESSION['userId'];

        //bind data
        $stmt->bindParam(':Header', $postData['header']);
        $stmt->bindParam(':Content', $postData['content']);
        if(isset($postData['imgLink'])) {
            $stmt->bindParam(':FileLink', $postData['imgLink']);
        } else {
            $stmt->bindParam(':FileLink', "");
        }
        $stmt->bindParam(':CreatedBy', $postData['createdBy']);

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