<?php
require 'personnages.php';
require 'manager.php';
require 'index.php';

// $personnage1 = new Personnage(1,'Lucy');
// $personnage2 = new Personnage(2,'Ryu');
$bdd = new PDO('mysql:host =localhost;dbname=tp1poo','root','',);
$manager = new PersonnagesManager($bdd);


// echo 'le combat opposera '.$personnage1->getNomPersonnage().' et '.$personnage2->getNomPersonnage().'<br>';


// function gestionAttaque($retour,$perso){
//     switch($retour){
//         case "attaquerSoi":
//             echo "<p>Ne t'attaque pas!</p>";
//         break;
//         case "degats":
//             echo "Le personnage ".$perso->getNomPersonnage()." reçoit des dégâts. Il lui reste ".$perso->getDegatsPersonnage()." de vie.";
//         break;
//         case "mort" :
//             echo "Le personnage ".$perso->getNomPersonnage()." a été tué.";
//             unset($perso);
//         break;
//     }
// }
// $persoAttaquant = $personnage1;
// $persoAttaque = $personnage2;

// gestionAttaque($persoAttaquant->frapper($persoAttaque),$persoAttaque);


if (isset($_POST['creer']) && isset($_POST['nom'])){

$perso = new Personnage (0,$_POST['nom']);

    if ($manager-> existPersonnage($perso->nom())){
    $message='le nom du personnage est déjà pris';
    unset($perso);
    }else{
    $manager->add($perso);
    $message ='le personnage a été créer';
    }
}

if(isset ($_POST['utiliser']) && isset($_POST['nom'])){

    if($manager->existPersonnage($_POST['nom'])){
        $perso = $manager->getPersonnage($_POST['nom']);
    }else{
        $message ='Ce personnage n existe pas';
    }
}
?>
<?php
    
    if ( isset ( $message )){
    echo '<p>',$message,'</p>';
    }
    if(isset($perso)){
        ?>
        <fieldset>
<legend> Infos personnage </legend>
<p>
Nom:<?php echo htmlspecialchars ($perso->nom()); ?><br />
Dégâts:<?php echo $perso->getDegatsPersonnage();?>
</p>
</fieldset>

<fieldset>
<legend> Quel joueur attaquer?</legend>
<p>
<?php
$persos= $manager-> getListPersonnages($perso->nom());

 if (empty($persos))
 {
 echo 'Personne à frapper!';
 }

 else
 {
 foreach ($persos as $unPerso)
 echo '<a href="?frapper=',$unPerso->id(),'">',
htmlspecialchars ($unPerso->nom()),'</a> (dégâts: ',
$unPerso->degats(),')<br />';
 }
 ?>
 </p>
 </fieldset>
 <?php
 }
 else
 {
 ?>
    
    <form action="" method="POST">
        <input type="text" name="nom">
        <input type="submit" value="Créer un personnage" name="creer">
        <input type="submit" value="Utiliser un personnage" name="utiliser">
    </form>
    <?php
 }
 ?>