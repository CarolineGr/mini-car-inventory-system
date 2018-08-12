<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/model.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare model object
$model = new model($db);

$response = array();
 
// get model id
$data = json_decode(file_get_contents("php://input"));
 
if( !isset( $data->id ) || ( empty( $data->id ) ) )
{
	$response["error"] = "Model id is missing.";
    echo json_encode($response);
    die();
}


// set model id to be deleted
$model->id = $data->id;
 
// delete the model
if($model->delete()){

	
	
    $response["success"] = "A record is deleted.";
    echo json_encode($response);
    die();
}
 
// if unable to delete the model
else{
    $response["error"] = "Unable to delete a record.";
    echo json_encode($response);
    die();
}
?>