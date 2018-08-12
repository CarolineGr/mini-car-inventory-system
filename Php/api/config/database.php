<?php

class Database
{
    private $host     = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name  = "minicar";
    public $conn;

    public function getConnection()
    {
        $this->conn = NULL;

        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch(PDOException $e)
        {
            echo "Connection error: " . $e->getMessage();
        }
 
        return $this->conn;

    }
}