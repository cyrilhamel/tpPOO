<?php
class Maison{
public $nom;
public $longueur;
public $largeur;
public $nbEtages;


public function surface(){
    $result = ($this->longueur * $this->largeur)*$this->nbEtages;
    echo "la maison $this->nom a une surface de $result mètres carré"; 
    }
}
?>