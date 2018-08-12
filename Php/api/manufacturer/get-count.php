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
$count = $manufacturer->getCount();
 
// check if more than 0 record found
if($count)
{
    echo json_encode(
        array("count" => $count)
    );
} 
else
{
    echo json_encode(
        array("count" => 0)
    );
}
?>