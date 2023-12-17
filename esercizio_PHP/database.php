<?php 
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new msqli($servername, $username, $password, $dbname);

        if($this->db->connect_error){
            die("COnnection failed: " . $this->db->connect_error);
        }
    }
}