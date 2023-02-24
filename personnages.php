<!--/*
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

}  */?>-->
<?php
abstract class Personnage
{
    protected $atout,
        $degats,
        $id,
        $nom,
        $timeEndormi,
        $type;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
        $this->type = strtolower(get_class($this));
     
    }

    public function hydrate(array $donnees)
    {
      foreach ($donnees as $key => $value)
      {
        $method = 'set'.ucfirst($key);
        
        if (method_exists($this, $method))
        {
          $this->$method($value);
        }
      }
    }

    public function estEndormi()
    {
        return $this->timeEndormi > time();
    }

    public function frapper(Personnage $perso)
    {
        if ($perso->id == $this->id) {
            return "ErreurCible";
        }

        if ($this->estEndormi()) {
            return "PersonneEndormie";
        }

        // On indique au personnage qu'il doit recevoir des dégâts.
        return $perso->recevoirDegats();
    }

    public function nomValide()
    {
        return !empty($this->nom);
    }

    public function recevoirDegats()
    {
        $this->degats += 5;

        // Si on a 100 de dégâts ou plus, on supprime le personnage de la BDD.
        if ($this->degats >= 100) {
            return "PersonneTuee";
        }

        // Sinon, on se contente de mettre à jour les dégâts du personnage.
        return "PersonneFrappee";
    }

    public function reveil()
    {
        $secondes = $this->timeEndormi;
        $secondes -= time();

        $heures = floor($secondes / 3600);
        $secondes -= $heures * 3600;
        $minutes = floor($secondes / 60);
        $secondes -= $minutes * 60;

        $heures .= $heures <= 1 ? ' heure' : ' heures';
        $minutes .= $minutes <= 1 ? ' minute' : ' minutes';
        $secondes .= $secondes <= 1 ? ' seconde' : ' secondes';

        return $heures . ', ' . $minutes . ' et ' . $secondes;
    }

    public function atout()
    {
        return $this->atout;
    }

    public function degats()
    {
        return $this->degats;
    }

    public function id()
    {
        return $this->id;
    }

    public function nom()
    {
        return $this->nom;
    }

    public function timeEndormi()
    {
        return $this->timeEndormi;
    }

    public function type()
    {
        return $this->type;
    }

    public function setAtout($atout)
    {
        $atout = (int) $atout;

        if ($this->degats >= 0 && $this->degats <= 25) {
            $this->atout = 4;
        } elseif ($this->degats > 25 && $this->degats <= 50) {
            $this->atout = 3;
        } elseif ($this->degats > 50 && $this->degats <= 75) {
            $this->atout = 2;
        } elseif ($this->degats > 75 && $this->degats <= 90) {
            $this->atout = 1;
        } else {
            $this->atout = 0;
        }
    }

    public function setDegats($degats)
    {
        $degats = (int) $degats;

        if ($degats >= 0 && $degats <= 100) {
            $this->degats = $degats;
        }
    }

    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function setNom($nom)
    {
        if (is_string($nom)) {
            $this->nom = $nom;
        }
    }

    public function setTimeEndormi($time)
    {
        $this->timeEndormi = (int) $time;
    }
}

class Magicien extends Personnage{
private $magie;

public function lancerUnSort($perso){
    $perso->frapper($this->magie);
}
}

class Guerrier extends Personnage{

}
?>

   