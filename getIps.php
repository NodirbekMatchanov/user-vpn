<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/account.php';

$database = new Database();
$db = $database->getConnection();
$account = new Account($db);
$stmt = $account->getIps();
$num = $stmt->rowCount();

if($num>0){
    $accounts_arr=array();
    $accounts_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $account_item=array(
            "id" => $id,
            "ip" => $ip,
            "status" => $status,
            "country" => $country,
            "city" => $city,
            "cert" => 'http://cb92144.tmweb.ru/web/certs/'.$cert,
        );
        array_push($accounts_arr["records"], $account_item);
    }
    http_response_code(200);
    echo json_encode($accounts_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No vpn ips found")
    );
}

?>