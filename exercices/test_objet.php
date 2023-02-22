<?php
//require 'maison.php';

//$maison = new Maison();

 //$maison->nom = "Angiviller";
 //$maison->longueur = 10;
 //$maison->largeur = 5;
 //$maison->nbEtages = 2;

 //$maison->surface();

 require 'vehicule.php';

 $vehicule = new Vehicule();

 $vehicule->setNomVehicule('Clio');
 $vehicule->setNbrRoue(4);
 $vehicule->setVitesse(190);
 

 echo $vehicule->demarrer();
?>