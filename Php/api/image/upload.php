<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate model object
include_once '../objects/image.php';
 
$database = new Database();
$db = $database->getConnection();
 
$image = new image($db);

$response = array();
 
// get posted data
$data = json_decode(file_get_contents("php://input"), true);

$image->code = $data["image"];
$image->name = $data["name"];
$image->created_at = date('Y-m-d H:i:s');

// create the model
if($image->create()){
    $response["success"] = "Image is uploaded successfully.";
    echo json_encode($response);
    die();
}
 
// if unable to create the model, tell the user
else{
    $response["error"] = "Unable to upload image.";
	echo json_encode($response);
	die();
}
?>