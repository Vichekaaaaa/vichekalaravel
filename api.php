<?php
// Basic API entry point

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode(["message" => "GET request received"]);
        break;
    case 'POST':
        echo json_encode(["message" => "POST request received"]);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
?>
