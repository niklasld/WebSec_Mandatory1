<?php 

    class EuDbConn {
        //config data
        private $host = "";
        private $db_name = "";
        private $username = '';
        private $password = '';

        public $conn;

        // get database connection
        public function getConnection() {
            include_once($_SERVER['DOCUMENT_ROOT'].'/user/config/localhost.php');
            $localhost = getLocalhost();
            
            if(!$localhost) {
                // $this->host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
                // $this->db_name = "socialnetworkdb";
                // $this->username = 'admin';
                // $this->password = 'Lasse-123';
                $this->host = "database-finalmandatory.cn5rmjtyyi6m.us-east-1.rds.amazonaws.com";
                $this->db_name = "socialnetworkdb";
                $this->username = 'elavatedUser';
                $this->password = 'JhdSaRde4G';
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