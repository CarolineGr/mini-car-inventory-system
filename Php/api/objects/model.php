<?php
class Model
{
    // database connection and table name
    private $conn;
    private $table_name = "models";
 
    // object properties
    public $id;
    public $name;
    public $color;
    public $year;
    public $registration_no;
    public $note;
    public $picture_one;
    public $picture_two;
    public $manufacturer;
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
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, color=:color, year=:year, registration_no=:registration_no, note=:note, picture_one=:picture_one, picture_two=:picture_two, manufacturer=:manufacturer, created_at=:created_at";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->color=htmlspecialchars(strip_tags($this->color));
        $this->year=htmlspecialchars(strip_tags($this->year));
        $this->registration_no=htmlspecialchars(strip_tags($this->registration_no));
        $this->note=htmlspecialchars(strip_tags($this->note));
        $this->picture_one=htmlspecialchars(strip_tags($this->picture_one));
        $this->picture_two=htmlspecialchars(strip_tags($this->picture_two));
        $this->manufacturer=htmlspecialchars(strip_tags($this->manufacturer));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
     
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":registration_no", $this->registration_no);
        $stmt->bindParam(":note", $this->note);
        $stmt->bindParam(":picture_one", $this->picture_one);
        $stmt->bindParam(":picture_two", $this->picture_two);
        $stmt->bindParam(":manufacturer", $this->manufacturer);
        $stmt->bindParam(":created_at", $this->created_at);
     
        //execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;

    }

    function read()
    {
        // query to read count
        $query = "SELECT count(*) FROM
                    " . $this->table_name . " 
                WHERE
                    registration_no LIKE ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->registration_no);

        // execute query
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn(); 

        return $number_of_rows;
    
    }

    function readById()
    {
        // query to read single record
        $query = "SELECT count(*) FROM
                    " . $this->table_name . " 
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        $number_of_rows = $stmt->fetchColumn(); 

        return $number_of_rows;
    
    }

    // delete the model
    function delete(){

        if($this->readById()>0)
        {
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
         
            // prepare query
            $stmt = $this->conn->prepare($query);
         
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
         
            // bind id of record to delete
            $stmt->bindParam(1, $this->id);
         
            // execute query
            if($stmt->execute()){
                return true;
            }
        }
     
        return false;
         
    }
}