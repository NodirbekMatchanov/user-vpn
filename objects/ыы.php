<?php
class Account{

    private $conn;

    public $id;
    public $vpnuser;
    public $vpnpass;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT id, username from radcheck";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create(){
        $op = ':=';
        $att = 'Cleartext-Password';
        $query = "INSERT INTO radcheck (username,attribute,op,value) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $this->vpnuser=htmlspecialchars(strip_tags($this->vpnuser));
        $this->vpnpass=htmlspecialchars(strip_tags($this->vpnpass));
        $stmt->bindParam(1, $this->vpnuser);
        $stmt->bindParam(2, $att);
        $stmt->bindParam(3, $op);
        $stmt->bindParam(4, $this->vpnpass);
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    function delete(){

        $query = "DELETE FROM radcheck where id=:data";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":data", $this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }


}
?>