<?php
class Personnage{
    private $idPersonnage;
    private $nomPersonnage;
    private $degatsPersonnage;

    function __construct($idPersonnage,$nomPersonnage,$degatsPersonnage){
        $this->idPersonnage = $idPersonnage;
        $this->nomPersonnage = $nomPersonnage;
        $this->degatsPersonnage = $degatsPersonnage;
    }
    public function getIdPersonnage()
    {
        return $this->idPersonnage;
    }

   
    public function setIdPersonnage($new_id_personnage)
    {
        $this->idPersonnage = $new_id_personnage;

        return $this;
    }

    public function getNomPersonnage()
    {
        return $this->nomPersonnage;
    }

 
    public function setNomPersonnage($new_nom_personnage)
    {
        $this->nomPersonnage = $new_nom_personnage;

        return $this;
    }

   
    public function getDegatsPersonnage()
    {
        return $this->degatsPersonnage;
    }

    public function setDegatsPersonnage($new_degats_personnage)
    {
        $this->degatsPersonnage = $new_degats_personnage;

        return $this;
    }

    public function frapper($perso){
        // prend en paramètre le perso ciblé
        // si l'id du perso ciblé est différent de celui qui frappe
            // alors on appelle la fonction recevoirDegats avec le perso à frapper en argument
        // sinon message "Attention on ne peut pas se frapper soi-même !"

        if($perso->getIdPersonnage() != $this->getIdPersonnage()){
            $perso->setDegatsPersonnage($perso->getDegatsPersonnage() - 5);
            if($perso->getDegatsPersonnage() <= 0){
                return "mort";
            }else{
                return "degats";
            }
        }else{
            return "attaquerSoi";
        }
    }




//methode attaquer personnage
public function attaquer(Personnage $cible){
   if($this->idPersonnage != $cible->getIdPersonnage()){
        $msg="";
       $retirerVie = $cible->retirerVie();
       $msg .= "hahaha";
       $msg .= $retirerVie;
       return $msg;
    } else {
       return 'attaquerSoi';
    }
//cibler le personnage à attaquer
//verifier si c'est le bon perso
//lancer la méthode retirerVie() sur le personnage ciblé

}


//methode retirer vie
public function retirerVie(){
//soustraire de la vie lorsque le personnage à subit une attaque 
//si le personnage n'a plus de vie lancer la methode supprimer personnage 
if ($this->degatsPersonnage >=5){
$this->setDegatsPersonnage($this->getDegatsPersonnage() - 5);
return $this->degatsPersonnage;
}else{
   return 'dead';
}
}


//methode supprimer si plus de vie
public function suppPerso($cible){
    //retirer le personnage en fin de version_compare
    unset($cible);
}

} 


?>

   