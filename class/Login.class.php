<?php
class Login extends Page {

    public function __construct() {
        parent::__construct();
        
        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->traiterConnexion();
        }
    }

    private function traiterConnexion() {
        $pseudo = $_POST['pseudo'] ?? '';
        $pass = $_POST['password'] ?? '';

        // Requête pour trouver l'utilisateur
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE pseudo_user = ?");
        $stmt->execute([$pseudo]);
        $user = $stmt->fetch();

        // Vérification du mot de passe
        if ($user && password_verify($pass, $user['mp_user'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['pseudo'] = $user['pseudo_user'];
            
            // Redirection vers l'accueil après connexion réussie
            header('Location: index.php?page=accueil');
            exit;
        } else {
            echo "<script>alert('Identifiants incorrects');</script>";
        }
    }

    protected function getContenu() {
        // Le HTML de la page de connexion (avec ton nouveau style craie)
        return <<<HTML
        <div class="login-wrapper">
            <div class="login-container">
                <div class="tabs">
                    <button class="active">Connexion</button>
                    <a href="?page=register"><button>Inscription</button></a>
                </div>

                <div class="form active" style="display:block;">
                    <form method="POST">
                        <input type="text" name="pseudo" placeholder="Votre Pseudo" required>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                        <button type="submit">SE CONNECTER</button>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
}
?>