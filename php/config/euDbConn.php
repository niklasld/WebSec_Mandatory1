<?php 

    class EuDbConn {
        //config data
        private $host = "localhost";
        private $db_name = "websecdatabasename";
        private $username = "root";
        private $password = "";

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