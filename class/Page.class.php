<?php
class Page {
    protected $pdo;
    protected $titre = "BOOLE & BIN";
    
    // Identifiants (Pour ton XAMPP local)
    private const HOST = 'localhost';
    private const DB_NAME = 'SAE_203';  
    private const USER = 'root';
    private const PASS = '';
    public function __construct() {
        // 1. Connexion BDD Sécurisée
        try {
            $this->pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4", self::USER, self::PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur BDD : " . $e->getMessage());
        }
        
        // Démarrage session si besoin
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Le Header (Commun à toutes les pages)
    protected function getHeader() {
        // Logique d'affichage : Connecté ou Pas ?
        if (isset($_SESSION['user_id'])) {
    $pseudo = htmlspecialchars($_SESSION['pseudo']);
    $userMenu = "
        <li><a href='?page=creation' style='color:#f1c40f;'>+ Créer un article</a></li>
        <li class='user-badge'>
            <span class='label-connecte'>Bonjour,</span>
            <span class='pseudo-style'>$pseudo</span>
            <a href='?page=logout' class='btn-logout' title='Se déconnecter'>✘</a>
        </li>";
}else {
            // Bouton simple pour se connecter
            $userMenu = "<li><a href='?page=login' class='btn-login'>Se connecter</a></li>";
        }

        return <<<HTML
        <!doctype html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>{$this->titre}</title>
            <link rel="stylesheet" href="./css/stylesacceuil.css">
        </head>
        <body>
        <header>
            <div class="titre">
                <a href="index.php"><h1>BOOLE & BIN</h1></a>
                <div class="menu-toggle" id="mobile-menu">☰</div>
            </div>
            
            <nav class="liste-horizontale">
                <ul>
                    <li><a href="?page=accueil">Accueil</a></li>
                    <li><a href="?page=article&id=1">Histoire</a></li>
                    <li><a href="?page=article&id=2">Booléen</a></li>
                    <li><a href="?page=article&id=3">Binaire</a></li>
                    <li><a href="?page=article&id=4">Logique</a></li>
                    <li><a href="?page=article&id=5">Appli</a></li>
                    <li><a href="?page=article&id=6">Bonus</a></li>
                    $userMenu
                </ul>
            </nav>
        </header>
        <main>
HTML;
    }

    // Le Footer (Commun à toutes les pages)
    protected function getFooter() {
        $year = date('Y');
        return <<<HTML
        </main>
        <footer>
            <p>&copy; {$year} SAE 203 - Tous droits réservés. <a href="?page=mentions">Mentions légales</a></p>
        </footer>
        </body>
        </html>
HTML;
    }

    // Fonction d'affichage global
    public function afficher() {
        echo $this->getHeader();
        echo $this->getContenu(); // C'est ici que les enfants vont insérer leur code !
        echo $this->getFooter();
    }

    // Méthode par défaut pour éviter les erreurs si l'enfant oublie
    protected function getContenu() {
        return "<p>Contenu en construction...</p>";
    }
}
?>