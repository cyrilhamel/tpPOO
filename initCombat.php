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
    switch ($_POST['type'])
    {
        case 'magicien' :
            $perso = new Magicien(array('nom'=> $_POST['nom']));
            break;

        case 'guerrier' :
            $perso = new Guerrier(array('nom'=> $_POST['nom']));
            break;
    }

    if(isset($perso)){

    
    $nom = $_POST['nom'];
    $_SESSION['nom']=$nom;
        if ($manager-> existPersonnage($perso->nom())){
        $message='le nom du personnage est déjà pris';
        unset($perso);
        }else{
        $manager->add($perso);
        $message ='le personnage a été créer';
        }
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
        
      if (!isset($perso))
      {
        $message = 'Merci de créer un personnage ou de vous identifier.';
      }
      
      else
      {
        if (!$manager->existPersonnage((int)$_GET['frapper']))
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
              $persoAFrapper->degats();
              break;
            
            case 'mort' :
              $message = 'Vous avez tué ce personnage !';
              $manager->deletePersonnage($persoAFrapper);
              
              break;

              case "PersonneEndormie":
                $message = 'Vous êtes endormi, vous ne pouvez pas frapper de personnage !';
                break;
          }
        }
    }
}
      elseif (isset($_GET['ensorceler'])) {
        if (!isset($perso)) {
            $message = 'Merci de créer un personnage ou de vous identifier.';
        } else {
            // Il faut bien vérifier que le personnage est un magicien.
            if ($perso->type() != 'magicien') {
                $message = 'Seuls les magiciens peuvent ensorceler des personnages !';
            } else {
                if (!$manager->exists((int) $_GET['ensorceler'])) {
                    $message = 'Le personnage que vous voulez frapper n\'existe pas !';
                } else {
                    $persoAEnsorceler = $manager->get((int) $_GET['ensorceler']);
                    $retour = $perso->lancerUnSort($persoAEnsorceler);
    
                    switch ($retour) {
                        case "ErreurCible":
                            $message = 'Mais... pourquoi voulez-vous vous ensorceler ???';
                            break;
    
                        case "PersonneEnsorcelee":
                            $message = 'Le personnage a bien été ensorcelé !';
    
                            $manager->update($perso);
                            $manager->update($persoAEnsorceler);
    
                            break;
    
                        case "PasDeMagie":
                            $message = 'Vous n\'avez pas de magie !';
                            break;
    
                        case "PersonneEnsorcelee":
                            $message = 'Vous êtes endormi, vous ne pouvez pas lancer de sort !';
                            break;
                    }
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
    Type : <?php echo ucfirst($perso->type()); ?><br />
    Nom:<?php echo htmlspecialchars ($perso->nom()); ?><br />
    Dégâts:<?php echo $perso->degats();?>
    <?php
                // On affiche l'atout du personnage suivant son type.
                switch ($perso->type()) {
                    case 'magicien':
                        echo 'Magie : ';
                        break;

                    case 'guerrier':
                        echo 'Protection : ';
                        break;
                }

                echo $perso->atout();
                ?>
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
     }else {
      if ($perso->estEndormi()) {
          echo 'Un magicien vous a endormi ! Vous allez vous réveiller dans ', $perso->reveil(), '.';
    
      }else{
     foreach ($persos as $unPerso)
     echo '<a href="?frapper=',$unPerso->id(),'">',
    htmlspecialchars ($unPerso->nom()),'</a> (dégâts: ',
    $unPerso->degats(),')<br />';
    if ($perso->type() == 'magicien') {
      echo ' | <a href="?ensorceler=', $unPerso->id(), '">Lancer un sort</a>';
  }
     }
    }

     ?>
     </p>
     </fieldset>
     <?php
     }else{
     ?>
        
        <form action="" method="POST">
            <input type="text" name="nom">
            Type :
                <select name="type">
                    <option value="magicien">Magicien</option>
                    <option value="guerrier">Guerrier</option>
                </select>
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