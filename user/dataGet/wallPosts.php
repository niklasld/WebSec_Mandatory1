<?php 

    function getWallPosts() {
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

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
            ORDER BY
                WallPostId DESC
        ';

        $stmt = $connection->prepare($sqlQuery);

        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $value) {
            //echo '<br>'.$value['WallPostId'].'<br>';
            echo '<h1>';
            out($value['Header']);
            echo '</h1>';
            echo 'Date created: ';
            out($value['Timestamp']);
            echo ' By: <i>';
            out($value['FirstName']);
            echo ' ';
            out($value['LastName']);
            echo '</i>';
            
            if($value['CreatedBy'] == $_SESSION['userId']) {
                echo '<form action="../deletePost" method="POST"><input type="hidden" name="WallPostIdDelete" value="';
                out($value['WallPostId']);
                echo '"><button type="submit" class="deletePost">Delete Post</button></form>';
            }
            // if($value['FileLink'] != "") {
            //     echo '<br><img src="'.$value['FileLink'].'" width="300" height="200"></img>';
            // }
            if($value['FileLink'] != "") {
                echo '<br><img src="upload/';
                out($value['FileLink']);
                echo '" width="300" height="200"></img>';
            }
            echo '<br><p>';
            out($value['Content']);
            echo '</p><br>';

            echo '<form method="POST" action="../replyWallPost">';
            echo '<input type="hidden" name="postId" value="';
            out($value["WallPostId"]);
            echo '">';
            echo '<button class="replyToWallPost" name="Reply" data-id="';
            out($value['WallPostId']);
            echo '">Reply</button><br><br>';
            echo '</form>';
            echo '<b>Replies:</b><br>';
            $replies = getRepliesFromId($value['WallPostId']);
            foreach($replies as $reply) {
                out($reply['Timestamp']);
                echo ' <i>';
                out($reply['FirstName']);
                echo ' ';
                out($reply['LastName']);
                echo '</i><br>';
                echo '<p>';
                out($reply['Reply']);
                echo '</p>';
            }
            echo '<br><hr>';
        }
    }

    function getRepliesFromId($id) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');
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