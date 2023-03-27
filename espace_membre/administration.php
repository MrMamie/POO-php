<?php 
    require "InclureClass.php";
    $bdd = new PDO("mysql:host=localhost;dbname=espace_membre", 'root', "");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $manager = new UtilisateursManager($bdd);
    if(isset($_GET["modifier"])){
        $utilisateur = $manager->getUtilisateur((int)$_GET["modifier"]);
    }

    if (isset($_POST["nom"])) {
        $utilisateur = new Utilisateurs(
            [
                "nom"=> $_POST["nom"],
                "prenom"=> $_POST["prenom"],
                "tel"=> $_POST["tel"],
                "email"=> $_POST["email"],
            ]
            );
        if (isset($_POST["id"])) {
            $utilisateur->setId((int)$_POST["id"]);
        }
        if ($utilisateur->isUserValid()) {
            $manager->mAj($utilisateur);
            $message = "Utilisateur modifié";
         ;
        }else {
            $erreurs = $utilisateur->getErreur();
        }
    }

    if(isset($_GET["supprimer"])){
        $manager->supprimer((int) $_GET['supprimer']);
        $message = "Utilisateur supprimer";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
</head>
<body>
<h1>Modification d'un membre</h1>

<form action="administration.php" method="post">
    <table>
     <?php if (isset($erreurs) && in_array(Utilisateurs::NOM_INVALIDE,$erreurs) ) {
         echo 'Le nom est invalide <br>';
     } ?>
        <tr>
            <td>Nom</td>
            <td><input type="text" name="nom" value=<?php if(isset($utilisateur)){echo $utilisateur->getNom();}?>></td>
        </tr>
        <?php if (isset($erreurs) && in_array(Utilisateurs::PRENOM_INVALIDE,$erreurs) ) {
         echo 'Le prénom est invalide <br>';
     } ?>
        <tr>
            <td>Prenom</td>
            <td><input type="text" name="prenom" value=<?php if(isset($utilisateur)){echo $utilisateur->getPrenom();}?>></td>
        </tr>
        <tr>
            <td>Téléphone</td>
            <td><input type="text" name="tel" value=<?php if(isset($utilisateur)){echo $utilisateur->getTel();}?>></td>
        </tr>
        <?php if (isset($erreurs) && in_array(Utilisateurs::MAIL_INVALIDE,$erreurs) ) {
         echo 'Le mail est invalide <br>';
     } ?>
        <tr>
            <td>Mail</td>
            <td><input type="text" name="email" value=<?php if(isset($utilisateur)){echo $utilisateur->getEmail();}?>></td>
        </tr>
    
    
        <input type="hidden" name="id" value="<?= (isset($utilisateur)? $utilisateur->getId():"")?>">
        
            <input type="submit" value="Modifier" name="Modifier">
    </table>
</form>
<br>
<?=(isset($message))?$message : "" ?>
<?= "<br><br>" ?>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Mail</th>
            <th>Modifier</th>
            <th>Suppression</th>
        </tr>
        <?php
            foreach($manager->getListeUtilisateur() as $utilisateur){
                echo " <tr>
                        <td>",$utilisateur->getNom() ,"</td>
                        <td>",$utilisateur->getPrenom(),"</td>
                        <td>",$utilisateur->getTel(), "</td>
                        <td>",$utilisateur->getEmail()," </td>
                        <td><a href=?modifier=",$utilisateur->getId(),">Modifier</a></td>
                        <td><a href=?supprimer=",$utilisateur->getId(),">Supprimer</a></td>
                </tr>";
            }

        ?>
        <tr>
            <td></td>
            <td></td>
        </tr>

    </table>
    <p><a href="./index.php">Accéder à l'accueil du site</a></p>
</body>
</html>