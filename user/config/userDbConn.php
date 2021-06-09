<?php 

    class UserDbConn {
        //config
        private $host = "";
        private $db_name = "";
        private $username = '';
        private $password = '';

        public $conn;

        // get database connection
        public function getConnection() {
            include_once('localhost.php');
            $localhost = getLocalhost();
            
            if($localhost == "aws") {
                // $this->host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
                // $this->db_name = "socialnetworkdb";
                // $this->username = 'admin';
                // $this->password = 'Lasse-123';
                $this->host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
                $this->db_name = "socialnetworkdb";
                $this->username = 'normalUser';
                $this->password = 'Leganu4md';
            }
            else if($localhost == "freedb") {
                $this->host = "sql11.freesqldatabase.com";
                $this->db_name = "sql11418180";
                $this->username = 'sql11418180';
                $this->password = 'FfKL3zk9bl';
            }
            else {
                $this->host = "localhost";
                $this->db_name = "socialnetworkdb";
                $this->username = 'root';
                $this->password = '';
            }

            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }
            catch(PDOExeption $exception) {
                out("Connection error: ".$exception->getMessage());
            }

            return $this->conn;
        } 
    }
?>