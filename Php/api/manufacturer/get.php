<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/manufacturer.php';
 
// instantiate database and manufacturer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$manufacturer = new Manufacturer($db);
 
// query manufacturers
$stmt = $manufacturer->get();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0)
{
 
    // manufacturers array
    $manufacturers_arr=array();

    $manufacturers_arr["success"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        extract($row);
 
        $manufacturer_item=array(
            "id" => $id,
            "name" => $name,
            "created_at" => $created_at
        );
 
        array_push($manufacturers_arr["success"], $manufacturer_item);
    }
 
    echo json_encode($manufacturers_arr);
} 
else
{
    echo json_encode(
        array("error" => "No manufacturers found.")
    );
}
?>