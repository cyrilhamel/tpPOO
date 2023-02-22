<?php
class Vehicule{
    private $nomVehicule;
    private $nbrRoue;
    private $vitesse;


public function getNomVehicule(){
    return $this->nomVehicule;
}    

public function setNomVehicule($new_nom_vehicule){
    $this->nomVehicule = $new_nom_vehicule;
}

public function getNbrRoue(){
    return $this->nbrRoue;
}    

public function setNbrRoue($new_nbr_roue){
    $this->nbrRoue = $new_nbr_roue;
}

public function getVitesse(){
    return $this->vitesse;
}    

public function setVitesse($new_vitesse){
    $this->vitesse = $new_vitesse;
}


public function demarrer(){
    $demarrage = '<p>Démarrage de la '.$this->getNomVehicule().'Vrooom !!!!</p>';
    return $demarrage;
}
}
?>