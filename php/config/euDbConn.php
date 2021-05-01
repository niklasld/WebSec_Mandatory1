<?php 

    class EuDbConn {
        //config data
        private $host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
        private $db_name = "socialnetworkdb";
        private $username = 'admin';
        private $password = 'Lasse-123';

        public $conn;

        // get database connection
        public function getConnection() {
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