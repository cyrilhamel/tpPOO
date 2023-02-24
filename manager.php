<?php

class PersonnagesManager{
    private $bdd;


 public function __construct($bdd)
 {
 $this->bdd = $bdd;
 }


 public function countPersonnages() {
    // Méthode pour compter le nombre de personnage
  $req=$this->bdd->prepare('SELECT COUNT(*)FROM personnage_v2');
  $req->execute();
  return $req->fetchColumn();
 }

public function existPersonnage($info){
   // verifie si le personnage existe
        if (is_int($info))
        {
         $req = $this->bdd->prepare('SELECT COUNT(*) FROM personnage_v2 WHERE id_ = :id_');
         $req -> execute(array(':id_' => $info));         
        }else{
         $req = $this->bdd->prepare('SELECT COUNT(*) FROM personnage_v2 WHERE nom = :nom');
         $req -> execute(array(':nom' => $info));        
        }
         return (bool) $req->fetchColumn();    
    }

 public function getListPersonnages($nom) {
    $persos = array();
    
    $req = $this->bdd->prepare('SELECT * FROM Personnage_v2 WHERE nom <> :nom ORDER BY nom');
    $req->execute(array(':nom'=>$nom));
    while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
      switch ($donnees['type_']) {
          case 'guerrier':
              $persos[] = new Guerrier($donnees);
              break;
          case 'magicien':
              $persos[] = new Magicien($donnees);
              break;
      }
  }

  return $persos;
}
     
   public function add ( Personnage $perso )
{   //ajouter des personnages
$req = $this->bdd -> prepare ('INSERT INTO personnages_v2 SET nom = :nom, type_ = :type_');
$req->bindValue (':nom',$perso->nom());
$req->bindValue (':type_',$perso->type());
$req->execute();
$perso = new Personnage($this->bdd->lastInsertId(),$perso->nom(), 100);
}

public function updatePersonnage(Personnage $perso){
   // modifie un personnage
   $req=$this->bdd->prepare('UPDATE personnage_v2 SET degats = :degats, timeEndormi = :timeEndormi, atout = :atout WHERE id_ = :id_');
   $req->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
   $req->bindValue(':timeEndormi', $perso->timeEndormi(), PDO::PARAM_INT);
   $req->bindValue(':atout', $perso->atout(), PDO::PARAM_INT);
   $req->bindValue(':id_',$perso->id(), PDO::PARAM_INT);
   $req->execute();
}

public function deletePersonnage(Personnage $perso){
   //supprime un personnage
   $req=$this->bdd->prepare('DELETE FROM personnage_v2 WHERE id_=:id_');
   $req->execute(array(':id_'=>$perso->id()));
}

public function getPersonnage($info){
   //recupere un personnage par son nom
   if (is_int($info))
      {
      $req = $this-> bdd-> prepare('SELECT * FROM personnage_v2 WHERE id_=:id_');
      $req->execute(array(':id_'=>$info));
      $donnees = $req->fetch (PDO::FETCH_ASSOC);
      return new Personnage($donnees['id_'],$donnees['nom'],$donnees['degats'],$donnees['timeEndormi'],$donnees['type_'],$donnees['atout']);
   }else{
      $req = $this->bdd->prepare('SELECT * FROM personnage_v2 WHERE nom = :nom');
      $req->execute(array(':nom'=>$info));
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      return new Personnage ($donnees['id_'],$donnees['nom'],$donnees['degats'],$donnees['timeEndormi'],$donnees['type_'],$donnees['atout']);
      }
   }
}
?>