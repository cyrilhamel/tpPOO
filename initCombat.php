<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de combat</title>
</head>
<body>
    
<?php
require 'personnages.php';
require 'manager.php';
/*$perso6=new Personnage (0,'test4');
$perso5=new Personnage (0,'test3');
print_r ($perso5);
$perso6->attaquer($perso5);
print_r($perso5);
 function chargerClasse($classname)
 {
  require $classname.'.class.php';
 }

 spl_autoload_register('chargerClasse');*/

session_start();

if (isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location: initCombat.php');
  exit();
}
if (isset($_SESSION['perso'])) 
 {
 $perso=$_SESSION['perso'];
 }



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

    $perso = new Personnage (0,$_POST['nom'],100);
    $nom = $_POST['nom'];
    $_SESSION['nom']=$nom;
        if ($manager-> existPersonnage($perso->getNomPersonnage())){
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
            $nom = $_POST['nom'];
            $_SESSION['nom']=$nom;
        }else{
            $message ='Ce personnage n existe pas';
        }
    }
    
    elseif (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
    {
        $user2 = $_GET['frapper'];
            settype($user2, "integer");
      if (!isset($perso))
      {
        $message = 'Merci de créer un personnage ou de vous identifier.';
      }
      
      else
      {
        if (!$manager->existPersonnage($user2))
        {
          $message = 'Le personnage que vous voulez frapper n\'existe pas !';
        }
        
        else
        {
            
           $persoAFrapper = $manager->getPersonnage($user2);

          $retour = $perso->frapper($persoAFrapper); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
          switch ($retour)
          {
            case 'attaquerSoi' :
              $message = 'Mais... pourquoi voulez-vous vous frapper ???';
              break;
            
            case 'degats' :
              $message = 'Le personnage a bien été frappé !';
              $manager->updatePersonnage($persoAFrapper);
              $persoAFrapper->getDegatsPersonnage();
              break;
            
            case 'mort' :
              $message = 'Vous avez tué ce personnage !';
              $manager->deletePersonnage($persoAFrapper);
              
              break;
          }
        }
      }
    }
    ?>
    <?php
        
        if ( isset ( $message )){
        echo '<p>',$message,'</p>';
        }
        if(isset($perso)){
            ?>
            <p><a href="?deconnexion=1">Déconnexion</a></p>
            <fieldset>
    <legend> Infos personnage </legend>
    <p>
    Nom:<?php echo htmlspecialchars ($perso->getNomPersonnage()); ?><br />
    Dégâts:<?php echo $perso->getDegatsPersonnage();?>
    </p>
    </fieldset>
    
    <fieldset>
    <legend> Quel joueur attaquer?</legend>
    <p>
    <?php
    $persos= $manager-> getListPersonnages($perso->getNomPersonnage());
    
     if (empty($persos))
     {
     echo 'Personne à frapper!';
     }
    
     else
     {
     foreach ($persos as $unPerso)
     echo '<a href="?frapper=',$unPerso->getIdPersonnage(),'">',
    htmlspecialchars ($unPerso->getNomPersonnage()),'</a> (dégâts: ',
    $unPerso->getDegatsPersonnage(),')<br />';
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
    </body>
    </html>
    <?php
    if (isset($perso)) 
    {
      $_SESSION['perso'] = $perso;
    }