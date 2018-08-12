<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate model object
include_once '../objects/model.php';
include_once '../objects/manufacturer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$model = new model($db);
$manufacturer = new Manufacturer($db);

$response = array();
 
// get posted data
$data = json_decode(file_get_contents("php://input"), true);

if( !isset($data['name']) || (empty($data['name'])) )
{
	$response["error"] = "Model name is required.";
    echo json_encode($response);
    die();
}

if( !isset($data['color']) || (empty($data['color'])) )
{
	$response["error"] = "Color is required.";
    echo json_encode($response);
    die();
}

if( !isset($data['year']) || (empty($data['year'])) )
{
	$response["error"] = "Registration year is required.";
    echo json_encode($response);
    die();
}

if( !isset($data['manufacturer']) || (empty($data['manufacturer'])) )
{
	$response["error"] = "Manufacturer is required.";
    echo json_encode($response);
    die();
}
else
{
	$manufacturer->id = $data['manufacturer'];
	$manufacturerCount = $manufacturer->readById();
	if($manufacturerCount<=0)
	{
	    $response["error"] = "Manufacturer is not found.";
	    echo json_encode($response);
	    die();
	}
}

if( isset($data['registration_no']) && ( ! (empty($data['registration_no'])) ) )
{
	// set model property values
	$model->registration_no = $data['registration_no'];

	$count = $model->read();

	if($count>=1)
	{
	    $response["error"] = "Registration no. is already used.";
	    echo json_encode($response);
	    die();
	}
}
else
{
	$response["error"] = "Registration no. is required.";
	echo json_encode($response);
	die();
}

$model->name = $data['name'];
$model->color = $data['color'];
$model->year = $data['year'];
$model->note = $data['note'];
$model->picture_one = $data['picture_one'];
$model->picture_two = $data['picture_two'];
$model->manufacturer = $data['manufacturer'];
$model->created_at = date('Y-m-d H:i:s');

// create the model
if($model->create()){
    $response["success"] = "Model is created successfully.";
    echo json_encode($response);
    die();
}
 
// if unable to create the model, tell the user
else{
    $response["error"] = "Unable to create model. Please try again later.";
	echo json_encode($response);
	die();
}
?>