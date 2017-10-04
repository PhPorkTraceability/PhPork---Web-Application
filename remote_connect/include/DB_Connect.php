<?php
class DB_Connect {
    private $conn;
 
    // Connecting to database
    public function connect() {
        require_once 'include/dbinfo.inc';
         
        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        
        if($this->conn->connect_error) {
        	die("Connection Failed: " . $this->conn->connect_error);
        }

        // return database handler
        return $this->conn;
    }
}