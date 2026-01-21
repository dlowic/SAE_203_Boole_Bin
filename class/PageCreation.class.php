<?php
class PageCreation extends Page {
    private string $message = '';

    public function __construct() {
        parent::__construct();
        
        // Sécurité : Si pas connecté, on vire !
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->traiterCreation();
        }
    }

    private function traiterCreation() {
        $titre = htmlspecialchars($_POST['titre']);
        $resume = htmlspecialchars($_POST['resume']);
        $contenu = htmlspecialchars($_POST['contenu']);
        $id_user = $_SESSION['user_id'];

        // 1. Insertion en BDD (Statut 0 = En attente)
        $sql = "INSERT INTO articles (titre, resume, contenu, id_user, statut) VALUES (?, ?, ?, ?, 0)";
        $stmt = $this->pdo->prepare($sql);
        
        if ($stmt->execute([$titre, $resume, $contenu, $id_user])) {
            $this->message = "<div class='success-chalk'>Article envoyé ! L'administrateur le validera sous 7 jours.</div>";
            
            // 2. Envoi du Mail à l'admin
            $to = "ton_email@gmail.com"; // REMPLACE PAR TON EMAIL
            $subject = "Nouvel article communauté : $titre";
            $msg = "Un utilisateur vient de poster un article.\n\nTitre: $titre\nRésumé: $resume\n\nConnectez-vous à la base de données pour le passer en statut 1.";
            // Sur XAMPP, ceci peut échouer sans config, on met un @ pour éviter l'erreur visuelle
            @mail($to, $subject, $msg); 

        } else {
            $this->message = "<div class='error-chalk'>Erreur lors de l'enregistrement.</div>";
        }
    }

    protected function getContenu() {
        return <<<HTML
        <div class="login-wrapper">
            <div class="login-container" style="max-width: 900px;">
                <h1 style="font-family:'EcritureCraie'; text-align:center; font-size:3rem; margin-bottom:20px;">Rédiger un Article</h1>
                
                {$this->message}

                <div class="form active" style="display:block;">
                    <form method="POST">
                        <label style="color:#ddd;">Titre de l'article :</label>
                        <input type="text" name="titre" placeholder="Ex: L'algèbre de Boole moderne" required>
                        
                        <label style="color:#ddd;">Court résumé :</label>
                        <input type="text" name="resume" placeholder="Ce que l'on va apprendre..." required>
                        
                        <label style="color:#ddd;">Contenu complet :</label>
                        <textarea name="contenu" rows="10" placeholder="Écrivez votre cours ici..." 
                                  style="width:100%; background:transparent; border:3px solid white; color:white; padding:10px; font-family:'Comic Sans MS'; font-size:1.2rem;" required></textarea>
                        
                        <br><br>
                        <button type="submit">SOUMETTRE À VALIDATION</button>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
}
?>