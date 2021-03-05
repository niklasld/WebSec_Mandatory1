<?php

    session_start();
    $_SESSION['logIn']=false;
    

    if(isset($_POST['username']) && isset($_POST['password'])){
        include_once('conn/database.php');

        $database = new Database();

        $usrName = $_POST['username'];
        $pwd = $_POST['password'];
    
        $connection = $database->getConnection();
    
        $sqlQuery = '
            SELECT 
                *
            FROM
                user
            WHERE
                userName =:userName
        ';

        $stmt = $connection->prepare($sqlQuery);

        //sanatize
        $usrName = htmlspecialchars(strip_tags($usrName));
        $pwd = htmlspecialchars(strip_tags($pwd));

        //bind stuff
        $stmt->bindParam(':userName', $usrName);

        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $loggedTime = new DateTime($data['last_login']);

        $currentTime = new DateTime(date('Y-m-d H:i:s'));
        $loggedTime->add(new DateInterval('PT' . 5 . 'M'));
        //$currentTime->add(new DateInterval('PT' . 1 . 'H'));

        $loggedTime = $loggedTime->format('Y-m-d H:i:s');
        $currentTime = $currentTime->format('Y-m-d H:i:s');
        
        

        if($data['attempt']+1<=3 || $loggedTime <= $currentTime) {
            echo $loggedTime.'<br>';
            echo $currentTime;
            if(password_verify($pwd, $data['password'])) {
                $_SESSION['logIn'] = true;
                $_SESSION['userId'] = $data['userId'];
                header('location: success.php');
            } else {
                $_SESSION['logIn']=false;
                echo "Fail";
                $sqlQuery = '
                    UPDATE
                        user
                    SET 
                        last_login=:ll,
                        attempt=:attempt
                    WHERE
                        userName=:userName
                ';

                $stmt = $connection->prepare($sqlQuery);
                $attempt = $data['attempt']+1;

                //-----------------------time stuff

                // $minutes_to_add = 5;
                // $addHour = 1;

                // $time = new DateTime(date('Y/m/d H:i:s'));
                // $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                // $time->add(new DateInterval('PT' . $addHour . 'H'));
        
                // $stamp = $time->format('Y/m/d H:i:s');

                //-----------------------/time stuff

                //bind stuff
                $stmt->bindParam(':ll', $currentTime);
                $stmt->bindParam(':attempt', $attempt);
                $stmt->bindParam(':userName', $usrName);

                $stmt->execute();
            }
        } else {
            $_SESSION['logIn']=false;
            echo "account is currently locked...<br>";
            echo $loggedTime.'<br>';
            echo $currentTime;

            // echo $timeCompare->format('Y-m-d H:i:s');
        }
    
        $connection = null;
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="#">
        <label>Username: </label><br>
        <input type="text" name="username" required><br>

        <label>Password: </label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>