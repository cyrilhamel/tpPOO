<?php
class PersonnagesManager{
    private $bdd;


 public function __construct($bdd)
 {
 $this->bdd = $bdd;
 }





 // Méthode pour compter le nombre de personnage
 public function countPersonnages() {
  return $this->bdd->querry('SELECT COUNT(*)FROM personnages')->fetchColumn();
    
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
    $persos = [];
    
    $req = $this->bdd->prepare('SELECT * FROM Personnages WHERE nom_personnage <> :nom_personnage ORDER BY nom_personnage');
    $req->execute(array(':nom_personnage' => $nom_personnage));
    $datas=$req->fetchall();

    foreach ($datas as )

    return $persos;
    
    $req->closeCursor();
}
     





   public function add ( Personnage $perso )
{   //ajouter des personnages
$req = $this->bdd -> prepare ('INSERT INTO personnages SET nom_personnage = :nom_personnage');
$req->bindValue (':nom_personnage',$perso->nom());
$req->execute();
}





public function updatePersonnage(){
   // modifie un personnage
}





public function deletePersonnage(Personnage $perso){
   //supprime un personnage
   $this->bdd->exec('DELETE FROM personnages WHERE id=',$perso->id());
}





public function getPersonnage($perso){
   //recupere un personnage par son nom
   if ( is_int ( $perso ) )
 {
 $req = $this-> bdd-> query ( 'SELECT id , nom_personnage FROM
personnages WHERE id = '. $perso ) ;
 $donnees = $req-> fetch ( PDO :: FETCH_ASSOC ) ;

 return new Personnage () ;
 }
 else
 {
 $req = $this -> bdd -> prepare ( 'SELECT id , nom_personnage FROM
personnages WHERE nom_personnage = :nom_personnage ') ;
$req -> execute ( array ( ':nom ' => $perso ) ) ;
 return new Personnage ( $req -> fetch ( PDO :: FETCH_ASSOC ) ) ; }


}


}
?>