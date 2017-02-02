<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
    // Si il existe une $_SESSION['id'], alors je redirige l'utilisateur vers le fichier compte.php
    if (isset($_SESSION['id'])) {
        header('Location: compte.php');
    }

    // Vérification que ma superglobal POST n'est pas vide
    if (!empty($_POST)) {
        /** Grâce à la fonction extract(), on va extraire du formulaire la valeur de l'attribut 
           * name afin de l'exploiter en tant que variable.
           * ------------------------------------------------------------------------
           * Exemple pour l'email :
           * On inscrira : $email au lieu de $_POST['email'];
           **/
        extract($_POST);
        
        $erreur = []; // Définition d'une variable contenant un tableau vide. On y stockera toutes nos valeurs erronées.

        require_once 'include/functions.php';

        // Conception d'une condition permettant de vérifier si chaque champ est vide. 
        if (empty($email)) { // Si c'est le cas on indiquera un message d'erreur.
            $erreur['email'] = "E-mail obligatoire";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // On filtre ici notre adresse email afin qu'elle respecte bien la bonne syntaxe d'un email.
            $erreur['email'] = "Format d'email incorrect";
        } elseif (!mailFree()) { // Contrôler qu'un membre n'existe pas déjà.
            $erreur['email'] = "Adresse mail déjà utilisée";
        }
        
        if (empty($password)) { // Si le mot de passe est vide
            $erreur['password'] = "Mot de passe obligatoire";
        } elseif (strlen($password) < 8) { // Si notre mot de passe dispose de moins de 8 caractères.
            $erreur['password'] = 'Votre mot de passe est trop cours, 8 caractères minimum...';
        }

        if (empty($passwordconf)) { // Si la confirmation du password est vide alors on affiche une message.
            $erreur['passwordconf'] = "Confirmation obligatoire";
        } elseif ($passwordconf != $password) { // Sinon si la valeur dans ce champ est diférente de password alors on aura un message d'erreur.'
            $erreur['passwordconf'] = "La correspondance entre les mots de passe n'est pas bonne.";
        }

        // On ajoute un if qui cette fois ci traitera si il n'y a pas d'erreur.
        if (!$erreur) {
            // Utilisation de notre fonction pour insérer un membre en base de donnée.
            // Dans les paramètres, en second argument on va nommer nos réponse afin de faire un tableau 
            // associatif.
            // -------------------------------------------------------------------------------------------
            // Inutile de le protéger vu qu'on utilise le filtre FILTER_VALIDATE_EMAIL
            // MDP Crypté
            bddInsert('INSERT INTO membre (mail, password) VALUES (:mail, :password)', [
                'mail' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            // Une fois envoyer, il faut vider l'intérieur des champs de notre formulaire avec la fonction unset();
            unset($email, $password, $passwordconf);
            // Message informant le visiteur que le message à bien été envoyer.
            $validation = 'Votre message à bien été envoyé. <br />Merci d\'avoir pris le temps de me contacter !';
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
      </head>
      <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container">
            <h1 class="text-center">Inscription</h1>
                <hr>
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="well">
                        <?php if (!empty($erreur)) { ?>
                            <div class="alert alert-danger text-center">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                <?php if (isset($erreur['email'])) : ?>
                                    <div><strong><?= $erreur['email'] ?></strong></div>
                                <?php endif; ?>
                                <?php if (isset($erreur['password'])) : ?>
                                    <div><strong><?= $erreur['password'] ?></strong></div>
                                <?php endif; ?>                                
                                <?php if (isset($erreur['passwordconf'])) : ?>
                                    <div><strong><?= $erreur['passwordconf'] ?></strong></div>
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
                        <form action="inscription.php" method="post" novalidate>
                            <div class="form-group">
                                <label for="email">E-mail :</label>
                                <input type="email" name="email" class="form-control" placeholder="Adresse e-mail" id="email" value="<?php if (isset($email)) { echo $email; } ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe :</label>
                                <input type="password" name="password" class="form-control" placeholder="Mot de passe" id="password" value="<?php if (isset($password)) { echo $password; } ?>">
                            </div>
                            <div class="form-group">
                                <label for="passwordconf">Confirmer le mot de passe :</label>
                                <input type="password" name="passwordconf" class="form-control" placeholder="Confirmez le mot de passe" id="passwordconf" value="<?php if (isset($passwordconf)) { echo $passwordconf; } ?>">
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary btn-block" value="Inscription">
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
