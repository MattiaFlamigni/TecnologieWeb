<?php

require_once("bootstrap.php");


if(isNotNull() && isValidValue()){
    $A = $_GET["A"];
    $B = $_GET["B"];
    $O = $_GET["O"];

    if(isPresentInDB($dbh, $A) && isPresentInDB($dbh, $B)){
        $vettoreA = readInsert($dbh, $A);
        $vettoreB = readInsert($dbh, $B);
        $vettoreFinale = UnisciOrConcatena($vettoreA, $vettoreB, $O);

        echo "Vettore A: ";     printVettore($vettoreA);
        echo "<br>";
        echo "Vettore B: " ;    printVettore($vettoreB);
        echo "<br>";
        echo "O: " . $O;
        echo ";    Vettore finale"; printVettore($vettoreFinale);
        echo "<br>";
        
        insert($dbh, $vettoreFinale);
        


        

    }else{
        echo "Insieme non presente nel db";
    }
}else{
    echo "Variabili non valide";
}







/*controllo che le variabili sia state passate correttamente */
function isNotNull(){
    if(isset($_GET["A"]) && isset($_GET["B"]) && isset($_GET["O"])){
        return true;
    }else{
        return false;
    }
}

/*controllo che le variabili A,B siano numeriche positive e O=i||u */
function isValidValue(){
    
    if(is_numeric($_GET["A"]) && is_numeric($_GET["B"]) && $_GET["A"]>0 && $_GET["B"]>0 && ($_GET["O"]=="i" || $_GET["O"]=="u")){
        return true;
    }
}


/*controllo che l'insieme sia presente nel db*/
function isPresentInDB($dbh, $insieme){
    return $dbh->isPresent($insieme);
}


/*Leggo i valori degli insiemi e li inserisco in due vettori distinti*/
function readInsert($dbh, $insieme){
    $valori = $dbh->getValue($insieme);
    $vettore = array();
    foreach($valori as $valore){
        array_push($vettore, $valore["valore"]);
    }
    return $vettore;
}


function UnisciOrConcatena($vettoreA, $vettoreB, $O){
    $vettore = array();
    if($O=="u"){
        //unione
        $vettore = array_merge($vettoreA, $vettoreB);
    }else{
        //intersezione
        $vettore = array_intersect($vettoreA, $vettoreB);
    }

    return $vettore;
}

/*inserisco i valori del vettore nel db*/
function insert($dbh, $vettore){
    foreach($vettore as $valore){
        $dbh->insertValue($valore, $dbh->getLastRowInsieme());
    }
}



function printVettore($vettore){
    foreach($vettore as $valore){
        echo $valore . " ";
    }
}




/*file: datdabase.php*/

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


    public function insertValue($valore, $idInsieme) {
        try {
            $stmt = $this->db->prepare("INSERT INTO insiemi (valore, insieme) VALUES (?, ?)");
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $this->db->error);
            }
    
            $stmt->bind_param('ii', $valore, $idInsieme);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            // Gestisci l'eccezione in modo opportuno (ad esempio, registrala o stampala a schermo)
            echo "Errore: " . $e->getMessage();
            return -1;  // Valore di errore, puoi scegliere un valore significativo per te
        } finally {
            // Chiudi la query e rilascia le risorse
            $stmt->close();
        }
    }


    public function getLastRowInsieme(){
        $stmt = $this->db->prepare("SELECT insieme FROM insiemi ORDER BY insieme DESC LIMIT 1");

        if(!$stmt){
            throw new Exception ("Errore nella preparazione della query: ".$this->db->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $last_value = $result->fetch_assoc()['insieme'];

        $nextValue = $last_value + 1;

        return $nextValue;  
    }
    
}








?>
