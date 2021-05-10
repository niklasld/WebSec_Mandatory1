<?php
    session_start();

    if(!isset($_SESSION['logInNU']) || $_SESSION['logInNU'] != true) {
        header("Location: ../../index.php"); 
    }

    if(isset($_POST['reply']) && isset($_POST['postId'])) {
        include_once('generalFunctions/postReply.php');

        $success = replyToWallPost($_POST);
        echo $success;

        
        if($success == true) {
            header("Location: wallView.php"); 
            //echo $_POST;
        }
        else {
            echo "an error happened...";
        }
    }
    // echo "postID: ".$_POST['postId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/styles.css">

    <style>
        <?php include_once('../../head.php'); ?>
    </style>

</head>
<body>
<?php include_once('../../header.php'); ?>
    <div class="content">
        <h1>Create reply</h1>
        <form method="POST" action="#">
            <input type="hidden" name="postId" value="<?php echo $_POST['postId'];?>">

            <label>Reply: </label><br>
            <textarea type="text" name="reply" rows="10" cols="50" required></textarea><br>

            <!-- <input type="hidden" name="createdBy" value="<?php //echo $_SESSION['userId'] ?>"> -->

            <button type="submit">Reply</button>
        </form>
        <?php 
            //include_once('./generalFunctions/core.php');
        ?>
    </div>
</body>
</html>