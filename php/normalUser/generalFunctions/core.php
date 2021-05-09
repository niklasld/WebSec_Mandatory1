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
            if($value['CreatedBy'] == $_SESSION['userId']) {
                echo '<form action="#" method="POST"><input type="hidden" name="WallPostIdDelete" value="'.$value['WallPostId'].'"><button type="submit" class="deletePost">Delete Post</button></form>';
            }
            if($value['CreatedBy'] == $_SESSION['userId']) {
                echo '<form action="updateWallPost.php" method="POST"><input type="hidden" name="WallPostIdUpdate" value="'.$value['WallPostId'].'"><button type="submit" class="updateWallPost">Update Post</button></form>';
            }

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


    function getWallPostById($wallPostId) {
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                WallPostId,
                Header,
                Content,
                FileLink
            FROM
                wallposts
            WHERE
                wallposts.WallPostId =:wallPostId
        ';
        $stmt = $connection->prepare($sqlQuery);

        //sanitize
        $wallPostId = htmlspecialchars(strip_tags($wallPostId));
        
        //bind params
        $stmt->bindParam(':wallPostId', $wallPostId); 

        $stmt->execute();

        $result = $stmt->fetch();

        if(!isset($result['FileLink'])) {
            $result['FileLink'] = "";
        }
        echo '<link rel="stylesheet" href="../../css/styles.css">';
        echo '<div xmlns="http://www.w3.org/1999/html">';
        echo '<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">';
        echo '<div class="container">';
        echo '<ul class="navbar-nav mr-5"><li class="nav-item"><a class="nav-link" href="../normalUser/wallView.php">Front Page</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="../normalUser/generalFunctions/signOut.php">Sign out</a></li></ul></div></nav></div>';
        echo '<div class="content">';
        echo '<form method="POST" action="updateWallPost.php">';
        echo '<input type="hidden" name="wallPostId" value="'.$result['WallPostId'].'">';
        echo '<label>Header: </label><br>';
        echo '<input type="text" name="header" value="'.$result['Header'].'" required><br>';
        echo '<label>Content: </label><br>';
        echo '<textarea type="text" name="content" rows="10" cols="50" required>'.$result['Content'].'</textarea><br>';
        echo '<label>Image link: </label><br>';
        echo '<input type="text" name="imgLink" value="'.$result['FileLink'].'"><br>';
        echo '<button type="submit">Update WallPost</button>';
        echo '</div>';
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
                CreatedBy,
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

    function printUpdateReplies($replyId) {
        include_once('../../php/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $sqlQuery = '
            SELECT
                PostReplyId,
                Reply
            FROM
                postreply
            WHERE
                postreply.PostReplyId =:postReplyId
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanitize
        $replyId = htmlspecialchars(strip_tags($replyId));
        
        //bind params
        $stmt->bindParam(':postReplyId', $replyId); 

        $stmt->execute();

        $result = $stmt->fetch();

        //return $result;

        echo '<link rel="stylesheet" href="../../css/styles.css">';
        echo '<div xmlns="http://www.w3.org/1999/html">';
        echo '<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">';
        echo '<div class="container">';
        echo '<ul class="navbar-nav mr-5"><li class="nav-item"><a class="nav-link" href="../normalUser/wallView.php">Front Page</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="../normalUser/generalFunctions/signOut.php">Sign out</a></li></ul></div></nav></div>';
        echo '<div class="content">';
        echo '<form method="POST" action="updateReplyWP.php">';
        echo '<input type="hidden" name="postReplyId" value="'.$result['PostReplyId'].'">';
        echo '<label>Reply: </label><br>';
        echo '<input type="text" name="reply" value="'.$result['Reply'].'" required><br>';
        echo '<button type="submit">Update reply</button>';
        echo '</div>';
    }
?>