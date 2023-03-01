<?php
// Database
require_once("./classes/Database.php");
// Products
require_once("./classes/products/Book.php");
require_once("./classes/products/DVD.php");
require_once("./classes/products/Furniture.php");
// Actions
require_once("./classes/actions/AddProduct.php");
require_once("./classes/actions/ListBooks.php");
require_once("./classes/actions/Listdvd.php");
require_once("./classes/actions/ListFurniture.php");
require_once("./classes/actions/DeleteProduct.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, GET, POST");
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
if ($method == 'GET') {
    $jsonList = [];
    $listBooks = new ListBooks();
    $listBooks->prepare($database);
    $listBooks->run();
    while ($row = $listBooks->return_row()) {
        $row["id"] = $row["id"][0];
        array_push($jsonList, $row);
    }

    $listdvd = new ListDvd();
    $listdvd->prepare($database);
    $listdvd->run();
    while ($row = $listdvd->return_row()) {
        $row["id"] = $row["id"][0];
        array_push($jsonList, $row);
    }
    $listfurniture = new ListFurniture();
    $listfurniture->prepare($database);
    $listfurniture->run();
    while ($row = $listfurniture->return_row()) {
        $row["id"] = $row["id"][0];
        array_push($jsonList, $row);
    }
    for ($i = 0; $i < count($jsonList); $i++) {
        for ($j = 0; $j < count($jsonList) - $i - 1; $j++) {
            if ($jsonList[$j]["id"] > $jsonList[$j + 1]["id"]) {
                $temp = $jsonList[$j + 1];
                $jsonList[$j + 1] = $jsonList[$j];
                $jsonList[$j] = $temp;
            }

        }

    }
    http_response_code(200);
    echo json_encode($jsonList);

}
if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!array_key_exists("SKU", $data) || !array_key_exists("Price", $data) || !array_key_exists("Type", $data) || !array_key_exists("Name", $data)) {
        http_response_code(400);
        exit();
    }
    $product;
    switch ($data["Type"]) {
        case 'books':
            if (!array_key_exists("Weight", $data)) {
                http_response_code(400);
                exit();
            }
            $product = new Book($data["SKU"], $data["Name"], floatval($data["Price"]), floatval($data["Weight"]));
            break;
        case 'dvd':
            if (!array_key_exists("Size", $data)) {
                http_response_code(400);
                exit();
            }
            $product = new DVD($data["SKU"], $data["Name"], floatval($data["Price"]), floatval($data["Size"]));
            break;
        case 'furniture':
            if (!array_key_exists("Length", $data) || !array_key_exists("Width", $data) || !array_key_exists("Height", $data)) {
                http_response_code(400);
                exit();
            }
            $product = new Furniture($data["SKU"], $data["Name"], floatval($data["Price"]), intval($data["Length"]), intval($data["Width"]), intval($data["Height"]));
            break;

        default:
            http_response_code(400);
            exit();
    }
    $save = new AddProduct();
    $save->prepare($database, $product);
    $save->run();
    http_response_code(200);
}
if ($method == 'HEAD') {
    $data = json_decode(file_get_contents('php://input'), true);
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
?>