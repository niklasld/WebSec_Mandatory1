<?php 

    function set_csrf(){
        if(session_status() == 1){ session_start(); }
        $csrf_token = bin2hex(random_bytes(25));
        $_SESSION['csrf'] = $csrf_token;
        echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';
    }
    
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
            echo '<form action="#" method="POST">'.set_csrf().'<input type="hidden" name="WallPostIdDelete" value="'.$value['WallPostId'].'"><button type="submit" class="deletePost">Delete Post</button></form>';
            $replies = getRepliesFromId($value['WallPostId']);
            foreach($replies as $reply) {
                echo '<b>'.$reply['FirstName'].' '.$reply['LastName'].'</b>';
                echo '<p>'.$reply['Reply'].'</p>';
                echo '<p>Date created: '.$reply['Timestamp'].'</p><br>';
                echo '<form action="generalFunctions/deleteReply.php" method="POST">'.set_csrf().'<input type="hidden" name="ReplyDelete" value="'.$reply['PostReplyId'].'"><button type="submit" class="deleteReply">Delete Reply</button></form>';
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