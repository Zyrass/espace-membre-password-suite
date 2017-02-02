<?php 
// Fonction permettant de vérifier la présence d'un membre ou non en base de donnée.
// On récupère les informations dans la base de donnée.
function accountExist() : array {
    // Conception d'une variable membre qui disposera de la fonction bddSelect() avec la requête.
    // ou l'on demande l'id et le password dans la table membre ou le mail est marqué.
    // On saisit en seconde arguments, ce que l'utilisateur à saisit dans le champ email du formulaire.
    $membre = bddSelect('SELECT id, password FROM membre WHERE mail = ?', [$_POST['email']]);

    // On créer une condition qui dit que si la variable membre n'est pas vide et que, le password
    // a bien été vérifié avec la fonction password_verify() avec pour argument, le contenu
    // du champ password qu'à saisit l'utilisateur et le tableau qu'on a obtenu via notre requete.
    if (!empty($membre) && password_verify($_POST['password'], $membre[0]['password'])) {
        return $membre[0];
    } else {
        return [];
    }
}

// On va créer une fonction qui va retourner un tableau vide.
// Dans ce tableau vide, on va récupérer les informations qui seront utiliser pour la source de l'image.
// Ce tableau pour le moment retourne uniquement un tableau vide vu qu'il faut un accès en BDD.
function accountInformations() :array {
    return [];
}

// Fonction de suppression dans la BDD que ce soit avec la méthode query ou prepare.
// Le premier argument correspond à notre requête sql
// Le second paramètre correspond au variable que pourrait contenir notre requete. Si il n'y en a pas,
// on initialise par défaut un tableau vide qui correspondra à la méthode query.
// On retournera un entier qui permettra d'indiqué le nombre de suppression.'
function bddDelete(string $query, array $params = []) :int {
    // Pour se connecter à la bdd, on va utiliser un require.
    require 'pdo.php';

    // - Conception d'une condition qui dit que si $params contient des variables, 
    // alors on exécutera la méthode prépare
    // - Sinon se sera la méthode query qui sera appliqué.
    if ($params) {
        $req = $bdd->prepare($query);
        $req->execute($params);
    } else {
        $req = $bdd->query($query);
    }

    // On récupère le tout dans une variable deleted et on utilisera la méthode rowCount();
    // qui nous permettra de compter le nombre de ligne supprimer
    $deleted = $req->rowCount();
    // Enfin on retournera le resultat de notre variable deleted.
    return $deleted;
}

// Fonction d'insertion dans la BDD que ce soit avec la méthode query ou prepare.
// Le premier argument correspond à notre requête sql
// Le second paramètre correspond au variable que pourrait contenir notre requete. Si il n'y en a pas,
// on initialise par défaut un tableau vide qui correspondra à la méthode query.
// On retournera un entier qui permettra d'indiqué le nombre d'ajout qu'il y aura eu.
function bddInsert(string $query, array $params = []) :int {
    // Pour se connecter à la bdd, on va utiliser un require.
    require 'pdo.php';

    // - Conception d'une condition qui dit que si $params contient des variables, 
    // alors on exécutera la méthode prépare
    // - Sinon se sera la méthode query qui sera appliqué.
    if ($params) {
        $req = $bdd->prepare($query);
        $req->execute($params);
    } else {
        $req = $bdd->query($query);
    }

    // On récupère le tout dans une variable inserted et on utilisera la méthode rowCount();
    // qui nous permettra de compter le nombre de ligne ajouter
    $inserted = $req->rowCount();
    // Enfin on retournera le resultat de notre variable inserted.
    return $inserted;
}

// Fonction pour selectionner dans la BDD que ce soit avec la méthode query ou prepare.
// Le premier argument correspond à notre requête sql
// Le second paramètre correspond au variable que pourrait contenir notre requete. Si il n'y en a pas,
// on initialise par défaut un tableau vide qui correspondra à la méthode query.
function bddSelect(string $query, array $params = []) {
    // Pour se connecter à la bdd, on va utiliser un require.
    require 'pdo.php';

    // - Conception d'une condition qui dit que si $params contient des variables, 
    // alors on exécutera la méthode prépare
    // - Sinon se sera la méthode query qui sera appliqué.
    if ($params) {
        $req = $bdd->prepare($query);
        $req->execute($params);
    } else {
        $req = $bdd->query($query);
    }

    // On récupère le tout dans une variable data et on utilise la méthode fetchAll(); 
    $data = $req->fetchAll();
    // Enfin on retournera le resultat de notre variable data.
    return $data;
}

// Fonction de mise à jour dans la BDD que ce soit avec la méthode query ou prepare.
// Le premier argument correspond à notre requête sql
// Le second paramètre correspond au variable que pourrait contenir notre requete. Si il n'y en a pas,
// on initialise par défaut un tableau vide qui correspondra à la méthode query.
// On retournera un entier qui permettra d'indiqué le nombre de modification qu'il y aura eu.
function bddUpdate(string $query, array $params = []) :int {
    // Pour se connecter à la bdd, on va utiliser un require.
    require 'pdo.php';

    // - Conception d'une condition qui dit que si $params contient des variables, 
    // alors on exécutera la méthode prépare
    // - Sinon se sera la méthode query qui sera appliqué.
    if ($params) {
        $req = $bdd->prepare($query);
        $req->execute($params);
    } else {
        $req = $bdd->query($query);
    }

    // On récupère le tout dans une variable updated et on utilisera la méthode rowCount();
    // qui nous permettra de compter le nombre de ligne modifié
    $updated = $req->rowCount();
    // Enfin on retournera le resultat de notre variable updated.
    return $updated;
}

// Fonction permettant de simuler la présence d'une adresse email ou nous via un teste simple.
// true     -> Permet de dire que l'adresse mail est disponible.
// false    -> Permet de dire que l'adresse mail n'est pas disponible.
function mailFree() : bool  {
    // On créer une variable membre qui contiendra la fonction bddUpdate()
    // on sélectionnera l'id de la table membre selon le mail qu'on aura marqué.
    // En second argument on récupèrera ce que l'utilisateur aura saisi comme mail.
    $membre = bddSelect('SELECT id FROM membre WHERE mail = ?', [$_POST['email']]);

    // On ajoute une condition qui dit que si il existe une adresse email, on retournera false.
    // Sinon true.
    if ($membre) {
        return false;
    } else {
        return true;
    }
};

// Fonction permettant l'envoi d'un mail au format html
// Il faut se rendre dans la doc php afin de récupérer les headers correspondant à : 
// - l'émetteur du mail
// - Le sujet du mail
// - le message
// La doc officiel traitant sur le sujet est à cette adresse : https://secure.php.net/manual/fr/function.mail.php
function mailHtml(string $subject, string $message) {
    // L'ajout d'en-têtes simples, spécifiant au MUA les adresses "From"
    $headers = 'From: Membre001 <membre001@espace-membre.dev>' . "\r\n";
    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8';

    // On envoi le mail avec la fonction mail.
    mail($_POST['email'], $subject, $message, $headers);
}

// Fonction permettant de siluer que le mot de passe saisit est correcte.
// - true saisit correct
// - false saisit incorrect
function passwordOk() :bool {
    return true;
}

// On initialise une fonction permettant de sauvegrder le mot de passe généré. 
// Ou lorsqu'on voudra le modifier via le formulaire de changement de mot de passe.
// ------------------------------------------------------------------------------------
// Utilisation de l'opérateur null coalescing nous sera utile vu que le nouveau mot de passe
// peut être soit équivalent à la variable password qu'on aura mis en argument dans notre fonction.
// Soit, avec la superglobale $_POST() qui sera transmise grâce au changement de mot de passe dans 
// l'espace membre.
 // ------------------------------------------------------------------------------------
 // Dans l'argument de la fonction, on définit une chaine vide par défaut. Ainsi on n'aura pas l'obligation
 // de saisir un argument lors de notre initialisation.
 // - $_POST['email'] corresponddra à notre formulaire dans l'espace membre
 // - $password correspondra au formulaire d'oubli et donc la génération du mot de passe.'
function passwordSave(string $password = "") {
    $newpassword = $_POST['newpassword'] ?? $password;
    // Conception d'une condition qui traitera la transmission des données dans la bdd selon ce qu'on aura décidé.
    if (isset($_POST['email'])) {
        // Création d'une variable membre qui contiendra la fonction bddUpdate();
        // Avec SET on mettra à jour le champ password mais on y ajoutera la clause WHERE
        // afin de spécifier qu'on veut changer le password équivalent à un mail spécifique.
        bddUpdate('UPDATE membre SET password = :password WHERE mail = :email', [
            "password" => password_hash($newpassword, PASSWORD_DEFAULT),
            "email" => $_POST['email']
        ]);
    } else {
        // Gestion changement du mot de passe en BDD
    }
}
