<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jeu de combat TP_POO</title>
</head>
<body>
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
    ?>
