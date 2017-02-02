<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
    // Si il n'existe pas de $_SESSION['id'], je redirige l'utilisateur vers le fichier connexion.php
    if (!isset($_SESSION['id'])) {
        header('Location: connexion.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Mon compte</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700,300">
        <link rel="stylesheet" href="css/style.css">
      </head>
      <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container profil">
                <h1 class="text-center">Mon compte</h1>
                <hr>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="well text-center">
                            <blockquote class="blockquote-reverse">
                                <p>Sur votre compte, vous pouvez changer le mot de passe ou votre image de profil.</p>
                            </blockquote>
                            <hr>
                            <a href="avatar.php" class="btn btn-primary">Changer mon image de profil</a>
                            <a href="password.php" class="btn btn-default">Changer mon mot de passe</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include 'include/footer.php' ?>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>
