   <?php
    require "InclureClass.php";

    $bdd = new PDO("mysql:host=localhost;dbname=espace_membre", 'root', "");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $manager = new UtilisateursManager($bdd);

    if (isset($_POST["nom"])) {
        $utilisateur = new Utilisateurs(
            [
                "nom"=>$_POST["nom"],
                "prenom"=>$_POST["prenom"],
                "tel"=>$_POST["tel"],
                "email"=>$_POST["mail"]
            ]
        );
        if ($utilisateur->isUserValid()) {
            echo "Utilisateur enregistrer";
            $manager->inserer($utilisateur);
        }else{
            $erreurs = $utilisateur->getErreur();
        }
    }
    ?>



   <!DOCTYPE html>
   <html lang="fr">

   <head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Inscription utilisateur</title>
   </head>

   <body>
       <h1>Inscription d'un membre</h1>

       <form action="inscription.php" method="post">
           <table>
            <?php if (isset($erreurs) && in_array(Utilisateurs::NOM_INVALIDE,$erreurs) ) {
                echo 'Le nom est invalide <br>';
            } ?>
               <tr>
                   <td>Nom</td>
                   <td><input type="text" name="nom"></td>
               </tr>
               <?php if (isset($erreurs) && in_array(Utilisateurs::PRENOM_INVALIDE,$erreurs) ) {
                echo 'Le prénom est invalide <br>';
            } ?>
               <tr>
                   <td>Prenom</td>
                   <td><input type="text" name="prenom"></td>
               </tr>
               <tr>
                   <td>Téléphone</td>
                   <td><input type="text" name="tel"></td>
               </tr>
               <?php if (isset($erreurs) && in_array(Utilisateurs::MAIL_INVALIDE,$erreurs) ) {
                echo 'Le mail est invalide <br>';
            } ?>
               <tr>
                   <td>Mail</td>
                   <td><input type="text" name="mail"></td>
               </tr>
               <tr>
                   <td><input type="submit" value="Enregistrer" name="enregistrer"></td>
               </tr>
           </table>
       </form>
       <p><a href="index.php">Retour accueil</a></p>
   </body>

   </html>