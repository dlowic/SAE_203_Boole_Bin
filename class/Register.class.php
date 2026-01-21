<?php
class Register extends Page {
    private string $message = '';

    public function __construct() {
        parent::__construct();

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = htmlspecialchars($_POST['pseudo'] ?? '');
            $pass = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($pass !== $confirm) {
                // Message d'erreur stylé (voir CSS plus bas)
                $this->message = "<div class='error-chalk'>Les mots de passe ne correspondent pas !</div>";
            } elseif ($this->registerUser($pseudo, $pass)) {
                // Succès : redirection
                header('Location: index.php?page=login');
                exit;
            } else {
                $this->message = "<div class='error-chalk'>Ce pseudo est déjà pris !</div>";
            }
        }
    }

    private function registerUser(string $pseudo, string $password): bool {
        // Vérif doublon
        $stmt = $this->pdo->prepare("SELECT id_user FROM users WHERE pseudo_user = ?");
        $stmt->execute([$pseudo]);
        if ($stmt->fetch()) return false;

        // Création
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (pseudo_user, mp_user) VALUES (?, ?)");
        return $stmt->execute([$pseudo, $hash]);
    }

    protected function getContenu() {
        return <<<HTML
        <div class="login-wrapper"> <div class="login-container">
                <div class="tabs">
                    <a href="?page=login"><button>Connexion</button></a>
                    <button class="active">Inscription</button>
                </div>

                {$this->message}

                <div class="form active" style="display:block;">
                    <form method="POST">
                        <input type="text" name="pseudo" placeholder="Choisir un pseudo" required>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
                        <button type="submit">S'INSCRIRE</button>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
}
?>