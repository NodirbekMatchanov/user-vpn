<?php
class Database{
    private $host = "localhost";
    private $db_name = "cb92144_vpn";
    private $username = "cb92144_vpn";
    private $password = "1Xc2fCf1";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
