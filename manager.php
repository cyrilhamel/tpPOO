<?php

class PersonnagesManager{
    private $bdd;


 public function __construct($bdd)
 {
 $this->bdd = $bdd;
 }


 public function countPersonnages() {
    // Méthode pour compter le nombre de personnage
  $req=$this->bdd->prepare('SELECT COUNT(*)FROM personnages');
  $req->execute();
  return $req->fetchColumn();
 }

public function existPersonnage($info){
   // verifie si le personnage existe
        if (is_int($info))
        {
         $req = $this->bdd->prepare('SELECT COUNT(*) FROM personnages WHERE id_personnage = :id_personnage');
         $req -> execute(array(':id_personnage' => $info));         
        }else{
         $req = $this->bdd->prepare('SELECT COUNT(*) FROM personnages WHERE nom_personnage = :nom_personnage');
         $req -> execute(array(':nom_personnage' => $info));        
        }
         return (bool) $req->fetchColumn();    
    }

 public function getListPersonnages($nom_personnage) {
    $persos = array();
    
    $req = $this->bdd->prepare('SELECT * FROM Personnages WHERE nom_personnage <> :nom_personnage ORDER BY nom_personnage');
    $req->execute(array(':nom_personnage'=>$nom_personnage));
    while ($donnees=$req->fetch(PDO::FETCH_ASSOC)){
      $persos[]=new Personnage($donnees['id_personnage'],$donnees['nom_personnage'],$donnees['degats_personnage']);
    }
    return $persos;
    }
     
   public function add ( Personnage $perso )
{   //ajouter des personnages
$req = $this->bdd -> prepare ('INSERT INTO personnages SET nom_personnage = :nom_personnage, degats_personnage = :degats_personnage');
$req->bindValue (':nom_personnage',$perso->getNomPersonnage());
$req->bindValue (':degats_personnage',$perso->getDegatsPersonnage());
$req->execute();
$perso = new Personnage($this->bdd->lastInsertId(),$perso->getNomPersonnage(), 100);
}

public function updatePersonnage(Personnage $perso){
   // modifie un personnage
   $req=$this->bdd->prepare('UPDATE personnages SET degats_personnage = :degats_personnage WHERE id_personnage = :id_personnage');
   $req->bindValue(':degats_personnage', $perso->getDegatsPersonnage(), PDO::PARAM_INT);
   $req->bindValue(':id_personnage',$perso->getIdPersonnage(), PDO::PARAM_INT);
   $req->execute();
}

public function deletePersonnage(Personnage $perso){
   //supprime un personnage
   $req=$this->bdd->prepare('DELETE FROM personnages WHERE id_personnage=:id_personnage');
   $req->execute(array(':id_personnage'=>$perso->getIdPersonnage()));
}

public function getPersonnage($info){
   //recupere un personnage par son nom
   if (is_int($info))
      {
      $req = $this-> bdd-> prepare('SELECT * FROM personnages WHERE id_personnage=:id_personnage');
      $req->execute(array(':id_personnage'=>$info));
      $donnees = $req->fetch (PDO::FETCH_ASSOC);
      return new Personnage($donnees['id_personnage'],$donnees['nom_personnage'],$donnees['degats_personnage']);
   }else{
      $req = $this->bdd->prepare('SELECT * FROM personnages WHERE nom_personnage = :nom_personnage');
      $req->execute(array(':nom_personnage'=>$info));
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      return new Personnage ($donnees['id_personnage'],$donnees['nom_personnage'],$donnees['degats_personnage']);
      }
   }
}
?>