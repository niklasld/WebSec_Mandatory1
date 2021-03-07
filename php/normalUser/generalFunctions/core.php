<?php 
    function getWallPosts() {
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                WallPostId,
                Header,
                Content,
                FileLink,
                Timestamp,
                FirstName,
                LastName, 
                CreatedBy
            FROM
                wallposts
            INNER JOIN 
                users
            ON
                wallposts.CreatedBy = users.UserId
        ';

        $stmt = $connection->prepare($sqlQuery);

        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $value) {
            //echo '<br>'.$value['WallPostId'].'<br>';
            echo '<h1>'.$value['Header'].'</h1>';
            echo 'Date created: '.$value['Timestamp'].' By: <i>'.$value['FirstName'].' '.$value['LastName'].'</i>';
            if($value['CreatedBy'] == $_SESSION['userId']) {
                echo '<form action="#" method="POST"><input type="hidden" name="WallPostIdDelete" value="'.$value['WallPostId'].'"><button type="submit" class="deletePost">Delete Post</button></form>';
            }
            if($value['FileLink'] != "") {
                echo '<br><img src="'.$value['FileLink'].'" width="300" height="200"></img>';
            }
            echo '<br><p>'.$value['Content'].'</p><br>';
            echo '<button name="Reply" data-id="'.$value['WallPostId'].'">Reply</button><br><br>';
            echo '<b>Replies:</b><br>';
            $replies = getRepliesFromId($value['WallPostId']);
            foreach($replies as $reply) {
                echo '<p>'.$reply['Reply'].'</p>';
                echo $reply['Timestamp'].' <i>'.$reply['FirstName'].' '.$reply['LastName'].'</i><br>';
            }
        }
    }

    function getRepliesFromId($id) {
        include_once('../../php/config/userDbConn.php');
        $database = new UserDbConn();
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                PostReplyId,
                Reply,
                Timestamp,
                FirstName,
                LastName,
                WallId 
            FROM 
                postreply
            INNER JOIN 
                users
            ON
                postreply.CreatedBy = users.UserId
            WHERE
                WallId =:WallId
        ';

        $stmt = $connection->prepare($sqlQuery);

        $stmt->bindParam(':WallId', $id);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
?>