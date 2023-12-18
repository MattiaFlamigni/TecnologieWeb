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

function insert($dbh, $vettore){
    foreach($vettore as $valore){
        $dbh->insertValue($valore);
    }


}







function printVettore($vettore){
    foreach($vettore as $valore){
        echo $valore . " ";
    }
}













?>
