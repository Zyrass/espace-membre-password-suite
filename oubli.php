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

        require_once 'include/functions.php'; // Récupération du fichier function.

        // Maintenant passons à la vérification de l'émail saisi.
        if (empty($email)) { // 1 - Si l'email n'a pas été saisit
            $erreur = 'Désolé, vous devez obligatoirement saisir une adresse email...';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // 2 - Si l'email n'a pas la bonne syntaxe
            $erreur = "Vérifiez la syntaxe de votre adresse email.";
        } elseif (mailFree($email)) { // 3 - Si l'email n'existe pas.
            $erreur = "Je suis désolé, cette adresse est inconnue...";
        }

        // Passons à la vérification si il n'existe aucune erreur.
        if (!isset($erreur)) {
            // Ici on génère le nouveau mot de passe en combinant deux fonction (bin2hex et random_bytes). 
            // On viendra le stocker le résultat dans la variable $password.
            $password = bin2hex(random_bytes(8)); // Ici on aura 16 caractères généré

            // On initialise une fonction permettant de sauvegarder le mot de passe généré. 
            // Ou lorsqu'on voudra le modifier via le formulaire de changement de mot de passe.
            passwordSave($password);

            // Définition du message qui sera envoyé par mail lors de la génération d'un nouveau mot de passe.'
            $message = '
                <fieldset>
                    <legend>Mot de passe perdu</legend>
                    <h1>Voici votre nouveau mot de passe :</h1>
                    <hr>
                    <p>Voici donc le mot de passe qui a été générée pour vous : <br />
                    <mark><strong>' . $password . '</strong></mark><br /></p>
                    <hr>
                    <p>Attention, pensez à le changer lors de votre prochaine connexion sur votre espace membre.</p>
                </fieldset>
            ';

            // Dans un premier temps, on fait la conception d'une nouvelle fonction qui nous permettra 
            // de traiter le html dans nos mails. Ainsi on allègera le code de cette façon.
            // ----------------------------------------------------------------------------
            // Dans un second temps, on indique : un sujet et dans en tant que premier argument 
            // et on y ajoute la variable message qu'on a créer plus haut.'
            mailHtml('Génération d\'un mot de passe oublié', $message);

            // Une fois le mail envoyé, il faut vider le formulaire avec la fonction unset()
            unset($email);

            // Enfin conception d'un message de validation permettant à l'utilisateur de voir que tout c'est bien passé.
            $validation = "Votre nouveau mot de passe a été généré correctement.<br />Vérifiez votre boîte mail.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Mot de passe oublié</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700,300">
        <link rel="stylesheet" href="css/style.css">
      </head>
      <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container">
                <h1 class="text-center">Mot de passe oublié</h1>
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
                            <?php if (isset($validation)) : ?>
                            <div class="alert alert-success text-center">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                <div><strong><?= $validation ?></strong></div>
                            </div>
                            <?php endif; ?>
                            <form action="oubli.php" method="post" novalidate>
                                <input type="email" name="email" class="form-control" placeholder="Saisir ici, l'adresse e-mail de votre compte" value="<?php if (isset($email)) { echo $email; } ?>">
                                <hr>
                                <input type="submit" class="btn btn-primary btn-block" value="Soumettre">
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
