<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate manufacturer object
include_once '../objects/manufacturer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$manufacturer = new manufacturer($db);

$response = array();
 
// get posted data
$data = json_decode(file_get_contents("php://input"), true);

if( isset($data['name']) && (!empty( $data['name'] )) )
{
	// set manufacturer property values
	$manufacturer->name = $data['name'];

	$count = $manufacturer->read();

	if($count>=1)
	{
	    $response["error"] = "Manufacturer name is already present.";
	    echo json_encode($response);
	    die();
	}

	$manufacturer->created_at = date('Y-m-d H:i:s');
}
else
{
	$response["error"] = "Manufacturer name is required.";
	echo json_encode($response);
	die();
}
 
// create the manufacturer
if($manufacturer->create()){
    $response["success"] = "Manufacturer is created successfully.";
    echo json_encode($response);
    die();
}
 
// if unable to create the manufacturer, tell the user
else{
    $response["error"] = "Unable to create manufacturer. Please try again later.";
	echo json_encode($response);
	die();
}
?>