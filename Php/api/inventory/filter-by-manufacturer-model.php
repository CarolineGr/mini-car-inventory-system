<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/inventory.php';
include_once '../objects/image.php';
 
// instantiate database and manufacturer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$inventory = new Inventory($db);
$image = new Image($db);

if( isset( $_GET["manufacturer"] ) && (!empty($_GET["manufacturer"])) && isset( $_GET["model"] ) && (!empty($_GET["model"])) )
{

    $manufacturer_id = $_GET["manufacturer"];
    $model_name = $_GET["model"];

    // query manufacturers
    $stmt = $inventory->getInventoriesByManufacturerAndModel($manufacturer_id, $model_name);
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
     
            if( isset($picture_one) && ( !empty($picture_one) ) )
            {
                $image->name = $picture_one;
                $picture_one = $image->getCodeByName();

            }

            if( isset($picture_two) && ( !empty($picture_two) ) )
            {
                $image->name = $picture_two;   
                $picture_two = $image->getCodeByName();
            }

            $inventory_item=array(
                "id" => $id,
                "name" => $name,
                "color" => $color,
                "year" => $year,
                "registration_no" => $registration_no,
                "note" => $note,
                "picture_one" => $picture_one,
                "picture_two" => $picture_two,
                "created_at" => date('M j, Y', strtotime($created_at))          
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
}
else
{
    echo json_encode(
        array("error" => "Please provide manufacturer and model info.")
    );
}
 

?>