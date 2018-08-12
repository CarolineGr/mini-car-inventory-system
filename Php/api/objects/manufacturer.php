<?php
class Manufacturer
{
    // database connection and table name
    private $conn;
    private $table_name = "manufacturers";
 
    // object properties
    public $id;
    public $name;
    public $created_at;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read manufacturers
    function get()
    {
     
        // select all query
        $query = "SELECT * FROM " . $this->table_name;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function getCount()
    {
        $query = "SELECT count(*) FROM " . $this->table_name; 
        $stmt = $this->conn->prepare($query); 
        $stmt->execute(); 
        $number_of_rows = $stmt->fetchColumn(); 
        return $number_of_rows;
    }

    function create()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, created_at=:created_at";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
     
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":created_at", $this->created_at);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function read()
    {
        // query to read single record
        $query = "SELECT count(*) FROM
                    " . $this->table_name . " 
                WHERE
                    name LIKE ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->name);

        // execute query
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn(); 

        return $number_of_rows;
    }

    function readById()
    {
        // query to get count
        $query = "SELECT count(*) FROM
                    " . $this->table_name . " 
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn(); 

        return $number_of_rows;
     
    }

}