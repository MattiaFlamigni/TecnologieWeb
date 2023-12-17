<?php 

/**
 * Classe per la connessione al database
 */
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);

        if($this->db->connect_error){
            die("COnnection failed: " . $this->db->connect_error);
        }
    }
}

?>