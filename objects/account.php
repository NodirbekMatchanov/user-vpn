<?php
class Account{

    private $conn;

    public $id_iden;
    public $vpnuser;
    public $id_secret;
    public $vpnpass;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT id, data from identities";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function get(){
        $query = "SELECT * from vpn_user_settings where vpnpassword=:vpnpassword, vpnlogin:=vpnlogin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":vpnpassword", $this->vpnpass);
        $stmt->bindParam(":vpnlogin", $this->vpnuser);
        $stmt->execute();
        return $stmt;
    }



    function getIps(){
        $query = "SELECT * from vpn_ips";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create(){
        $query = "INSERT INTO identities SET type=2, data=:data";
        $stmt = $this->conn->prepare($query);
        $this->vpnuser=htmlspecialchars(strip_tags($this->vpnuser));
        $stmt->bindParam(":data", $this->vpnuser);
        $stmt->execute();
        $this->id_iden = $this->conn->lastInsertId();

        $query = "INSERT INTO shared_secrets SET type=2, data=:data";
        $stmt = $this->conn->prepare($query);
        $this->vpnpass=htmlspecialchars(strip_tags($this->vpnpass));
        $stmt->bindParam(":data", $this->vpnpass);
        $stmt->execute();
        $this->id_secret = $this->conn->lastInsertId();

        $query = "INSERT INTO shared_secret_identity SET shared_secret=:idsecret, identity=:ididen";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idsecret", $this->id_secret);
        $stmt->bindParam(":ididen", $this->id_iden);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete(){

        $query = "DELETE FROM shared_secrets where id in (select shared_secret from shared_secret_identity where identity=:data)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":data", $this->id_iden);
        $stmt->execute();

        $query = "DELETE FROM identities where id=:data";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":data", $this->id_iden);
        $stmt->execute();

        $query = "DELETE FROM shared_secret_identity where identity=:data";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":data", $this->id_iden);
        if($stmt->execute()){
            return true;
        }
        return false;
    }


}
?>