<?php
// Database
require_once("./classes/Database.php");
// Actions
require_once("./classes/actions/DeleteProduct.php");
require_once("./classes/actions/ListBooks.php");
require_once("./classes/actions/Listdvd.php");
require_once("./classes/actions/ListFurniture.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST GET");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');
$host = '';
$dbname='';
$user= '';
$pass = '';
$database = new Database($host, $dbname, $user, $pass);
$database->conn();
if (!$database->check_conn()) {
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data == null) {
        http_response_code(400);
        return;
    }
    foreach ($data as $value) {
        if (!is_numeric($value)) {
            http_response_code(400);
            exit();
        }
    }
    $del = new DeleteProduct();
    foreach ($data as $value) {
        $del->prepare($database, $value);
        $del->run();
        http_response_code(200);
    }
}
if ($method == 'GET') {
    $jsonList = [];
    $listBooks = new ListBooks();
    $listBooks->prepare($database);
    $listBooks->run();
    while ($row = $listBooks->return_row()) {
        $row = $row["sku"];
        array_push($jsonList, $row);
    }

    $listdvd = new ListDvd();
    $listdvd->prepare($database);
    $listdvd->run();
    while ($row = $listdvd->return_row()) {
        $row = $row["sku"];
        array_push($jsonList, $row);
    }
    $listfurniture = new ListFurniture();
    $listfurniture->prepare($database);
    $listfurniture->run();
    while ($row = $listfurniture->return_row()) {
        $row = $row["sku"];
        array_push($jsonList, $row);
    }
     
    http_response_code(200);
    echo json_encode($jsonList);

} else {
    http_response_code(400);
}
?>