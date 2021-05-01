<?php 

    class UserDbConn {
        //config

        public $conn;

        // get database connection
        public function getConnection() {
            include_once('localhost.php');
            
            if($localhost) {
                $host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
                $db_name = "socialnetworkdb";
                $username = 'admin';
                $password = 'Lasse-123';
            }
            else {
                $host = "localhost";
                $db_name = "socialnetworkdb";
                $username = 'root';
                $password = '';
            }

            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }
            catch(PDOExeption $exception) {
                echo "Connection error: ".$exception->getMessage();
            }

            return $this->conn;
        } 
    }
?>