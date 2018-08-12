<?php
class Inventory
{
    // database connection and table name
    private $conn;
    private $tbl_model = "models";
    private $tbl_manufacturer = "manufacturers";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read manufacturers
    function get()
    {
     
        // select query
        $query = "SELECT m.id as model_id, m.name as model, mn.name as manufacturer, mn.id as manufacturer_id, COUNT(m.name) as inventory FROM " . $this->tbl_model . " as m INNER JOIN " . $this->tbl_manufacturer . " as mn on m.manufacturer = mn.id GROUP BY m.manufacturer, m.name ORDER BY mn.name ASC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function getInventoriesByManufacturerAndModel($manufacturer_id="", $model_name="")
    {
        // select query
        $query = "SELECT * FROM " . $this->tbl_model. " where (manufacturer = :manufacturer AND name LIKE :name)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":manufacturer", $manufacturer_id);
        $stmt->bindParam(":name", $model_name);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

}
