<?php 
    if(!is_csrf_valid()){
        // The form is forged
        // Code here
        echo "what=!";
        exit();
    }

    if(isset($_POST['header']) && isset($_POST['content'])) {

        $success = createWallPost($_POST);
        
        if($success == true) {
            header("Location: ../../wallview"); 
            //echo $_POST;
        }
        else {
            echo "an error happened...";
        }
    }
    
    function createWallPost($postData) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/userDbConn.php');

        $database = new UserDbConn();

        $connection = $database->getConnection();

        $file = rand(1000,100000)."-".$_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $folder="upload/";

        $new_file_name = strtolower($file);

        $final_file=str_replace(' ','-',$new_file_name);

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
        
        // if(isset($postData['imgLink'])){
        //     $postData['imgLink'] = htmlspecialchars(strip_tags($postData['imgLink']));
        // }

        $final_file = htmlspecialchars(strip_tags($final_file));

        $postData['createdBy'] = $_SESSION['userId'];

        //bind data
        $stmt->bindParam(':Header', $postData['header']);
        $stmt->bindParam(':Content', $postData['content']);
        // if(isset($postData['imgLink'])) {
        //     $stmt->bindParam(':FileLink', $postData['imgLink']);
        // } else {
        //     $stmt->bindParam(':FileLink', "");
        // }
        $stmt->bindParam(':FileLink', $final_file);
        $stmt->bindParam(':CreatedBy', $postData['createdBy']);

        move_uploaded_file($file_loc, $folder.$final_file);

        //var_dump($stmt);
        // try {
        //     $stmt->execute();
        //     return true;
        // }
        // catch(PDOException $e) {
        //     return false;
        // }

        try {
            if($file_type == "image/png" || $file_type == "image/jpeg") {
                $stmt->execute();
                return true; 
            } else {
                echo "Please select a valid file type - ";
            }
        }
        catch(PDOException $e) {
            return false;
        }
    }
?>