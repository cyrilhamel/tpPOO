<?php
require 'personnages.php';
require 'manager.php';

$personnage1 = new Personnage(1,'Lucy');
$personnage2 = new Personnage(2,'Ryu');
$bdd = new PDO('mysql:host =localhost;dbname=tp1poo','root','',);
$personnageManager = new PersonnagesManager($bdd);


echo 'le combat opposera '.$personnage1->getNomPersonnage().' et '.$personnage2->getNomPersonnage().'<br>';


function gestionAttaque($retour,$perso){
    switch($retour){
        case "attaquerSoi":
            echo "<p>Ne t'attaque pas!</p>";
        break;
        case "degats":
            echo "Le personnage ".$perso->getNomPersonnage()." reçoit des dégâts. Il lui reste ".$perso->getDegatsPersonnage()." de vie.";
        break;
        case "mort" :
            echo "Le personnage ".$perso->getNomPersonnage()." a été tué.";
            //unset($perso);
        break;
    }
}
$persoAttaquant = $personnage1;
$persoAttaque = $personnage2;

gestionAttaque($persoAttaquant->frapper($persoAttaque),$persoAttaque);







                                               



?>