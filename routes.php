<?php
    session_start();
    //echo $_SESSION['logInNU'];
    require_once("router.php");


    // ##################################################
    // ##################################################
    // ##################################################

    // Static GET
    // In the URL -> http://localhost
    // The output -> Index
    get('/', 'index.php');

    //normal user login
    post('/login', '/user/posts/login.php');

    //view for vieweing wallposts
    get('/wallview', '/user/views/wallView.php');

    //createWall Post
    get('/createWallPost', '/user/views/createWallPostView.php');
    post('/createWallPost', '/user/posts/createWallPost.php');


    //registerUser
    get('/registerUser', '/user/views/register.php');
    post('/registerUser', '/user/posts/register_user.php');

    //replyWallPost
    //get('/replyWallPost', '/user/views/replyWallPost.php');
    post('/replyWallPost', '/user/views/replyWallPost.php');
    post('/postReply', '/user/posts/postReply.php');

    //deleteWallPost
    //post('/deleteWallPost','/user/views/deleteWallPost');
    post('/deletePost', '/user/posts/deletePost.php');

    // ##################################################
    // ##################################################
    // ##################################################
    // any can be used for GETs or POSTs

    // For GET or POST
    // The 404.php which is inside the views folder will be called
    // The 404.php has access to $_GET and $_POST
    //any('/404','user/views/404.php');
?>