<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/image.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare manufacturer object
$image = new image($db);
 
// set ID property of manufacturer to be edited
$image->name = isset($_GET['name']) ? $_GET['name'] : die();
// $image->id = 1;
 
// read the details of manufacturer to be edited
$stmt = $image->get();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0)
{
 
    // manufacturers array
    $images_arr=array();

    $images_arr["success"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        // extract row
        extract($row);
 
        $image_item=array(
            "id" => $id,
            'name' => $name,
            "code" => $code,
            "created_at" => $created_at
        );
 
        array_push($images_arr["success"], $image_item);
    }
 
    echo json_encode($images_arr);
} 
else
{
    echo json_encode(
        array("error" => "No images found.")
    );
}


?>