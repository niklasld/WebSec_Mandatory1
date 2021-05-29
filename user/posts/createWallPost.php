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

        $file_type = $_FILES['file']['type'];
        if($file_type != "") {
            $file = rand(1000,100000)."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $folder="upload/";
    
            $new_file_name = strtolower($file);
    
            $final_file=str_replace(' ','-',$new_file_name);
            //$final_file=$file_type;
        } else {
            $final_file = "";
        }

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

        
        //var_dump($stmt);
        // try {
            //     $stmt->execute();
            //     return true;
            // }
            // catch(PDOException $e) {
                //     return false;
                // }
            
            try {
                if($file_type == "image/png" || $file_type == "image/jpeg" || $file_type == "") {
                    if($file_size<10000000) {
                        move_uploaded_file($file_loc, $folder.$final_file);
                        $stmt->execute();
                        return true;
                    }
                    else {
                        echo 'File to big... under 1 mb please...';
                        header("refresh:3; url=../../createWallPost");
                    }

                //return true; 
            } else {
                var_dump($file_type);
                echo "Please select a valid file type - ";
            }
        }
        catch(PDOException $e) {
            return false;
        }
    }
?>