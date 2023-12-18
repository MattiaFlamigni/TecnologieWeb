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

    public function isPresent($insieme){
        $stmt= $this->db->prepare("SELECT * FROM insiemi WHERE insieme=?");
        $stmt->bind_param('i', $insieme);
        $stmt->execute();

        //se la query ha prodotto risultati
        if($stmt->get_result()->num_rows > 0){
            return true;
        }

        return false;
        
    }

    public function getValue($insieme){
        $stmt = $this->db->prepare("SELECT valore FROM insiemi WHERE insieme=?");
        $stmt->bind_param('i', $insieme);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function insertValue($valore) {
        try {
            $stmt = $this->db->prepare("INSERT INTO insiemi (valore) VALUES (?)");
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $this->db->error);
            }
    
            $stmt->bind_param('i', $valore);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            // Gestisci l'eccezione in modo opportuno (ad esempio, registrala o stampala a schermo)
            echo "Errore: " . $e->getMessage();
            return -1;  // Valore di errore, puoi scegliere un valore significativo per te
        } finally {
            // Chiudi la query e rilascia le risorse
            $stmt->close();

            return false;
        }
    }
    
}

?>