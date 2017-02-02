<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Mon super site !</title>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php include 'include/header.php'; ?>
        <main>
            <div class="container">
                <h1 class="text-center">Ma page d'accueil</h1>
                <hr>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="jumbotron">
                            <h2>Présentation du contenu</h2>
                            <hr>
                            <p class="lead">Basé sur le tutoriel de Steven Sil sur tuto.com, nous allons nous entraîner à coder un espace membre.</p>

                            <p>Les couleurs sont modifiés ainsi qu'une adaptation du code pour que ce soit compatible avec bootstrap 3.</p>

                            <div class="alert alert-info">
                                <p>A savoir que de base Steven utilise la version 4.0.0 de bootstrap qui est au jour d'aujourd'hui bootstrap 4 reste encore en Alpha. (version : 4.0.6). Steven Sil propose une formation sur bootstrap 4 que je recommande.</p>
                            </div>
                            <hr>
                            <small>si cette formation vous intéresse voici le lien : <a href="https://fr.tuto.com/php/php-formation-complete-php,64171.html" target="_blank">Tuto PHP : Formation complète avec Php</a></small>
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
