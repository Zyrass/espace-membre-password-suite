<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
    // Si il existe une $_SESSION['id'], alors je redirige l'utilisateur vers le fichier compte.php
    if (isset($_SESSION['id'])) {
        header('Location: compte.php');
    }
    // Si notre superglobal $_POST n'est pas vide alors on convertie en variable les données saisie via le name de nos champs dand le formulaire.
    // Ainsi name="email" sera égale à $email au lieu de $_POST['email'];
    if (!empty($_POST)) {
        extract($_POST);

        require_once 'include/functions.php'; // On récupère le fichier de functionsvu qu'on a créer la fonction accountExist();

        // Ici on définit une variable membre ou on y stockera la fonction créer précédemment.
        $membre = accountExist(); 

        // Conception d'une condition qui dit que si la variable $membre existe, on lui ajoute une session avec la superglobal $_SESSION.
        // Puis on redirige l'utilisateur vers la page compte.php
        if ($membre) {
            $_SESSION['id'] = $membre['id'];
            header('Location: compte.php');
        } else { // Sinon ont crée une variable $erreur en lui définissant directement un message d'erreur.
            $erreur = "Les identifiants saisis ne sont pas correcte.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container">
                <h1 class="text-center">Connexion</h1>
                <hr>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="well">
                            <?php if (isset($erreur)) : ?>
                            <div class="alert alert-danger text-center">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                <div><strong><?= $erreur ?></strong></div>
                            </div>
                            <?php endif; ?>
                            <form action="connexion.php" method="post" novalidate>
                                <div class="form-group">
                                    <label for="email">E-mail :</label>
                                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail" id="email" value="<?php if (isset($email)) { echo $email; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe :</label>
                                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" id="password">
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-primary btn-block" value="Connexion">
                                <a href="oubli.php" class="text-warning">Mot de passe oublié ?</a>
                            </form>
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
