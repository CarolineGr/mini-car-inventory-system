<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/manufacturer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare manufacturer object
$manufacturer = new manufacturer($db);
 
// set ID property of manufacturer to be edited
$manufacturer->name = isset($_GET['name']) ? $_GET['name'] : die();
 
// read the details of manufacturer to be edited
$count = $manufacturer->read();
 
// create array
$manufacturer_arr = array(
    "id" =>  $manufacturer->id,
    "name" => $manufacturer->name,
    "description" => $manufacturer->description,
    "price" => $manufacturer->price,
    "category_id" => $manufacturer->category_id,
    "category_name" => $manufacturer->category_name
 
);
 
// make it json format
print_r(json_encode(array("count"=>$count)));

?>