<?php
// Vu qu'on utilise la superglobal $_SESSION nous devons obligatoirement spécifier un session_start() au début du code.
session_start();
// Re-définition de notre superglobal afin de vider son contenu en lui spécifiant un tableau vide
$_SESSION = [];

// Ici on colle le bloc se trouvant à cette adresse : https://secure.php.net/manual/fr/function.session-destroy.php
// --------------------------------------------------------------------------------------------------
// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Utilisation de la fonction session_destroy() qui permet de détruire une session.
session_destroy();

// Une fois tous supprimé, nous seront redirigez vers la page connexion.php.
// Le menu changera en réaffichant connexion et inscription tout en cachant cette fois-ci compte et déconnexion
header('Location: connexion.php');
