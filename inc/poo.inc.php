<?php
// On vérifie que la constante est définie dans l'index pour sécuriser l'accès
if (!defined("CHARGE_AUTOLOAD")) {
    die("Accès direct interdit.");
}

// Fonction d'autoloader simple
spl_autoload_register(function ($classname) {
    // Le dossier où sont tes classes
    $folder = './class/';
    // Le nom du fichier attendu (Ex: PageAccueil.class.php)
    $file = $folder . $classname . '.class.php';

    // Si le fichier existe, on le charge
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Optionnel : Pour débugger, décommente la ligne ci-dessous si ça plante encore
        // die("Erreur : Impossible de trouver le fichier " . $file);
    }
});
?>