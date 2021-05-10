<?php 
    function getWallPosts() {
        include_once('../../php/config/euDbConn.php');

        $database = new EuDbConn();

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
            ORDER BY
                Timestamp DESC
        ';

        $stmt = $connection->prepare($sqlQuery);

        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $value) {
            //echo '<br>'.$value['WallPostId'].'<br>';
            echo '<h1>'.$value['Header'].'</h1>';
            echo '<p>Date created: '.$value['Timestamp'].' By: <i>'.$value['FirstName'].' '.$value['LastName'].'</i></p>';
            
            if($value['FileLink'] != "") {
                echo '<br><img src="'.$value['FileLink'].'" width="300" height="200"></img>';
            }
            echo '<br><p>'.$value['Content'].'</p><br>';
            echo '<form action="#" method="POST"><input type="hidden" name="WallPostIdDelete" value="'.$value['WallPostId'].'"><button type="submit" class="deletePost">Delete Post</button></form>';
            echo '<form action="updateWallPost.php" method="POST"><input type="hidden" name="WallPostIdUpdate" value="'.$value['WallPostId'].'"><button type="submit" class="updateWallPost">Update Post</button></form>';
            echo '<form method="POST" action="../normalUser/replyWallPost.php">';
            echo '<input type="hidden" name="postId" value="'.$value["WallPostId"].'">';
            echo '<button class="replyToWallPost" name="Reply" data-id="'.$value['WallPostId'].'">Reply</button><br><br>';
            echo '</form>';
            $replies = getRepliesFromId($value['WallPostId']);
            foreach($replies as $reply) {
                echo '<b>'.$reply['FirstName'].' '.$reply['LastName'].'</b>';
                echo '<p>'.$reply['Reply'].'</p>';
                echo '<p>Date created: '.$reply['Timestamp'].'</p><br>';
                if($reply['CreatedBy'] == $_SESSION['userId']) {
                    echo '<form action="updateReplyWP.php" method="POST"><input type="hidden" name="ReplyUpdate" value="'.$reply['PostReplyId'].'"><button type="submit" class="updateReply">Update Reply</button></form>';
                }
            }
            echo '<br>';
            echo '<hr>';
        }
    }

    function getRepliesFromId($id) {
        include_once('../../php/config/euDbConn.php');
        $database = new EuDbConn();
        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                PostReplyId,
                Reply,
                Timestamp,
                CreatedBy,
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