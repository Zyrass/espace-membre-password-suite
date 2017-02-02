<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
    // Si il n'existe pas de $_SESSION['id'], je redirige l'utilisateur vers le fichier connexion.php
    if (!isset($_SESSION['id'])) {
        header('Location: connexion.php');
    }

    require_once 'include/functions.php'; // On récupère le fichier de functionsvu qu'on a créer la fonction accountExist();

    // La fonction accountInformations sera stocker dans la variable membre.
    // Elle permet de récupérer des informations qui seront utiliser pour la source de notre image.
    $membre = accountInformations();

    // On teste si la superglobale $_FILES['avatar'] existe. Egalement il faut regarder si il existe une erreur 0.
    // Ce qui voudrait dire que tout c'est bien passé dans le dossier temporaire du serveur.
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) { // Si il existe un fichier et qu'il n'y a pas d'erreur'
        // On veut :
        // - S'assurer que c'est uniquement le format jpeg et png qui seront utilisés.
        // - On va devoir regarder dans le tableau si une des valeur correspond au type 'jpeg/png' de notre fichier.
        // - Pour comparer on utilise la fonction in_array()
        // - On imbrique un if avec pour condition : Si elle ne se trouve pas dans un tableau, on aura une erreur.
        if (!in_array($_FILES['avatar']['type'], ['image/png', 'image/jpeg'])) { // Si on a aucune valeur correspondante, alors on aura une erreur
            $erreur = "Le format n'est pas le bon. Le format .PNG et .JPEG sont acceptés.";
        } elseif ($_FILES['avatar']['size'] > 102400 ) { // Définition de la taille maximal qui sera accepté par le serveur
            $erreur = "L'image que vous tentez d'uploadé est bien trop volumineuse. (100 Ko maximum)";
        }
        // Si tout est OK, on ajoute une nouvelle condition qui dit que si il n'y a pas d'erreur, on va récupérer
        // l'extenssion qui sera soit au format JPEG soit au format PNG.
        if (!isset($erreur)) { // Vérification si il n'existe pas d'erreur.
            // On a définit plus haut que le type MIME serait uniquement du PNG ou du JPEG.
            // Pour récupérer ces extensions, on va utiliser la fonction str_replace() qui va nous permettre
            // de remplacer un bout d'une chaine de caractère par autre chose.
            // ------------------------------------------------------------------------------
            // str_replace(arg1, arg2, arg3)
            // - arg1 --> Que-ce-qu'on va bien remplacer ?
            // - arg2 --> Par quoi ?
            // - arg3 --> Où ?
            $extension = str_replace('image/', '', $_FILES['avatar']['type']);
            // On créer une variable qui nous permettra de générer un nom aléatoire et donc éviter de se
            // retrouver avec une image qui pourrait porter le même nom.
            // Si par malheur les noms seraient identique, irrémédiablement on écraserait l'image d'un autre utilisateur.
            $name = bin2hex(random_bytes(8)) . '.' . $extension; // 8 octets en hexa c'est 16 caractères.
            // On va tester dans une condition  que si tout se passe bien on envoi dans la bdd
            // L'avatar et on supprimera l'ancien fichier. 
            // Si on rencontre une erreur on l'affichera.
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/avatar/' . $name)) {
                // Si ok mise à jour en BDD + Suppression de l'ancienne image.
                // Nous sommes obligé de rafraîchire la page pour afficher la nouvelle image.
                header('Location: avatar.php');
            } else { // Si rien n'a fonctionné, on indique un message d'erreur.
                $erreur = "Une erreur est survenue lors de l'envoie du fichier.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Changer d'avatar</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
      </head>
      <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container profil">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <h1 class="text-center">Changer d'avatar</h1>
                        <hr>
                        <div class="well">
                            <?php if (isset($erreur)) : ?>
                            <div class="alert alert-danger text-center">
                                <div><strong><?= $erreur ?></strong></div>
                            </div>
                            <?php endif; ?>
                            <div class="center-block">
                                <img src="" alt="avatar" class="img-circle img-fluid">
                            </div>
                            <form action="avatar.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="avatar" class="form-control-file">
                                <input type="submit" class="btn btn-primary btn-block" value="Changer d'avatar">
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
