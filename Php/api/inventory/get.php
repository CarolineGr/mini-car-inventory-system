<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/inventory.php';
 
// instantiate database and manufacturer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$inventory = new Inventory($db);
 
// query manufacturers
$stmt = $inventory->get();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0)
{
 
    // manufacturers array
    $inventory_arr=array();

    $inventory_arr["success"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        extract($row);
 
        $inventory_item=array(
            "model_id" => $model_id,
            "manufacturer_id" => $manufacturer_id,
            "model" => $model,
            "manufacturer" => $manufacturer,
            "inventory" => $inventory
        );
 
        array_push($inventory_arr["success"], $inventory_item);
    }
 
    echo json_encode($inventory_arr);
} 
else
{
    echo json_encode(
        array("error" => "No records found.")
    );
}
?>