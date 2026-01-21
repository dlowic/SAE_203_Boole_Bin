<?php
// 1. Définition de la constante de sécurité
define("CHARGE_AUTOLOAD", true);

// 2. Chargement de l'autoloader
require_once './inc/poo.inc.php';

// 3. Récupération de la page demandée
$pageName = $_GET['page'] ?? 'accueil';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 4. Routage (Switch)
switch ($pageName) {
    case 'accueil':
        $pageObject = new PageAccueil();
        break;

    case 'article':
        if ($id > 0) {
            $pageObject = new PageArticle($id);
        } else {
            $pageObject = new PageAccueil();
        }
        break;

    case 'login': // Attention aux minuscules !
    case 'Login':
        $pageObject = new Login();
        break;

    case 'register':
    case 'Register':
        // Assure-toi d'avoir créé/corrigé Register.class.php aussi !
        $pageObject = new Register();
        break;

    case 'mentions':
    case 'mentions-legales':
        $pageObject = new Mentions();
        break;

    case 'logout':
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    case 'creation':
        $pageObject = new PageCreation();
        break;
    default:
        $pageObject = new PageAccueil();
        break;
}

// 5. Affichage final (C'est cette ligne qui fait tout le travail)
$pageObject->afficher();
?>