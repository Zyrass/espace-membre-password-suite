<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
    // Si il n'existe pas de $_SESSION['id'], je redirige l'utilisateur vers le fichier connexion.php
    if (!isset($_SESSION['id'])) {
        header('Location: connexion.php');
    }

    // Si notre superglobal $_POST n'est pas vide alors on convertie en variable les données saisie via le name de nos champs dand le formulaire.
    // Ainsi name="email" sera égale à $email au lieu de $_POST['email'];
    if (!empty($_POST)) {
        extract($_POST);

        // Initialisation d'un tableau d'erreur vu qu'on peut ici se retrouver avec plusieurs erreurs à gérer.
        $erreur = [];
        // On récupère le fichier de functionsvu qu'on a créer la fonction accountExist();
        require_once 'include/functions.php';

        // Vérification pour l'ancien mot de passe qui aura été saisit
        if (empty($oldpassword)) { // Vérification si le champ est vide
            $erreur['oldpassword'] = "Désolé, l'ancien mot de passe est obligatoire...";
        } elseif (!passwordOk()) { // Vérification si l'ancien mot de passe correspond à celui auquel vous êtes connecté.
            $erreur['oldpassword'] = "Vous avez saisis un mauvais mot de passe...";
        }
        // Vérification pour le nouveau mot de passe
        if (empty($newpassword)) { // Vérification si le champ est vide
            $erreur['newpassword'] = "Désolé, le nouveau mot de passe est obligatoire...";
        } elseif (strlen($newpassword) < 8) { // Vérification sur la longeur de la chaîne avec la fonction strlen()
            $erreur['newpassword'] = "Désolé, votre nouveau mot de passe comprends moins de 8 caractères...";
        }
        // Vérification pour la confirmation du nouveau mot de passe
        if (empty($newpasswordconf)) { // Vérification si le champ est vide
            $erreur['newpasswordconf'] = "Désolé, la confirmation du mot de passe est obligatoire...";
        } elseif ($newpasswordconf != $newpassword) { // Vérification si la confirmation correspond au nouveau mot de passe.
            $erreur['newpasswordconf'] = "Votre confirmation ne correspond pas au nouveau mot de passe...";
        }

        // Vérification si il n'y a pas d'erreur dans notre tableau d'erreur.
        if (!$erreur) {
            // Si on ne rencontre aucune erreur, on enregistre avec la fonction passwordSave le contenu de $newpassword.
            passwordSave();
            // Conception d'une variable de validation
            $validation = "Vous venez de mettre à jour votre mot de passe.";
        }

    }
?>
<!DOCTYPE html>
<html lang="fr">
      <head>
           <meta charset="utf-8">
           <title>Changer de mot de passe</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700,300">
        <link rel="stylesheet" href="css/style.css">
      </head>
      <body>
        <?php include 'include/header.php'; ?>
        <main>
            <di class="container profil">
                <h1 class="text-center">Changer de mot de passe</h1>
                <di class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                    <hr>
                        <div class="well">
                            <?php if (!empty($erreur)) { ?>
                            <div class="alert alert-danger text-center">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                <?php if (isset($erreur['oldpassword'])) : ?>
                                    <div><strong><?= $erreur['oldpassword'] ?></strong></div>
                                <?php endif; ?>
                                <?php if (isset($erreur['newpassword'])) : ?>
                                    <div><strong><?= $erreur['newpassword'] ?></strong></div>
                                <?php endif; ?>                                
                                <?php if (isset($erreur['newpasswordconf'])) : ?>
                                    <div><strong><?= $erreur['newpasswordconf'] ?></strong></div>
                                <?php endif; ?>
                            </div>
                        <?php } else { ?>
                            <?php if (isset($validation)) : ?>
                                <div class="alert alert-success text-center">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    <div><strong><?= $validation ?></strong></div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                            <form action="password.php" method="post">
                                <div class="form-group">
                                    <label for="oldpassword">Ancien mot de passe :</label>
                                    <input type="password" name="oldpassword" class="form-control" placeholder="Ancien mot de passe ici..." id="oldpassword">
                                </div>
                                <div class="form-group">
                                    <label for="newpassword">Nouveau mot de passe :</label>
                                    <input type="password" name="newpassword" class="form-control" placeholder="Nouveau mot de passe ici..." id="newpassword">
                                </div>
                                <div class="form-group">
                                    <label for="newpasswordconf">Confirmez le nouveau mot de passe :</label>
                                    <input type="password" name="newpasswordconf" class="form-control" placeholder="Confirmez ici..." id="newpasswordconf">
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-primary btn-block" value="Changer de mot de passe">
                            </form>
                        </div>
                    </div>
                </di>
            </di>            
        </main>

        <?php include 'include/footer.php' ?>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>
