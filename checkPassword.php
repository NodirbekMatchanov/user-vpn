<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/account.php';

$database = new Database();
$db = $database->getConnection();
$account = new Account($db);
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->vpnuser) &&
    !empty($data->vpnpass)
){
    // check account property values
    $account->vpnuser = $data->vpnuser;
    $account->vpnpass = $data->vpnpass;
    $stmt = $account->get();
    $num = $stmt->rowCount();

    if($num>0){
        http_response_code(201);
        echo json_encode(array("message" => "found account " . $account->id_iden));
    } else{
        http_response_code(503);
        array("message" => "No vpn accounts found");
    }
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No vpn accounts found")
    );
}

