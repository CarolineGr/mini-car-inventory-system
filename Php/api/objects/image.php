<?php
class Image
{
    // database connection and table name
    private $conn;
    private $table_name = "images";
 
    // object properties
    public $id;
    public $name;
    public $code;
    public $created_at;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, code=:code, created_at=:created_at";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->code=$this->code;
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
     
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":created_at", $this->created_at);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function get()
    {
        // query to read single record
        $query = "SELECT * FROM
                    " . $this->table_name . " 
                WHERE
                    name = ?
                LIMIT
                    0,1";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->name);

        // execute query
        $stmt->execute();

        return $stmt;
     
    }

    function getCodeByName()
    {
    	if( $this->name )
    	{
    		// query to read single record
	        $query = "SELECT * FROM
	                    " . $this->table_name . " 
	                WHERE
	                    name = ?
	                LIMIT
	                    0,1";
	     
	        // prepare query statement
	        $stmt = $this->conn->prepare( $query );
	     
	        $this->name=htmlspecialchars(strip_tags($this->name));

	        // bind id of product to be updated
	        $stmt->bindParam(1, $this->name);

	        // execute query
	        $stmt->execute();

	        $num = $stmt->rowCount();

	        if($num>0)
			{

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        	
		        	// extract row
		        	extract($row);
		        	$this->code = $code;
		        	break;
		    	}

			}

			return $this->code;
    	}

    	return false;

    }

}