$(document).ready(function() {
    $(document).on('click', 'button', function() {
        window.location.replace('../normalUser/createWallPost.php');
        console.log("button clicked");
    })
});