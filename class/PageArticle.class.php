<?php
class PageArticle extends Page {
    private $id_article;

    public function __construct($id) {
        parent::__construct();
        $this->id_article = (int)$id;
    }

    protected function getContenu() {
        // 1. Récupération de l'article AVEC le pseudo de l'auteur (Jointure)
        $sql = "SELECT a.*, u.pseudo_user 
                FROM articles a 
                LEFT JOIN users u ON a.id_user = u.id_user 
                WHERE id_article = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->id_article]);
        $article = $stmt->fetch();

        if (!$article) return "<p style='color:white; text-align:center;'>Article introuvable.</p>";

        $titre = htmlspecialchars($article['titre']);
        $contenu = nl2br(htmlspecialchars($article['contenu']));
        
        // Gestion de l'auteur et de la date
        $pseudo = htmlspecialchars($article['pseudo_user'] ?? 'Administration'); // Si pas d'auteur, c'est l'Admin
        $date = date("d/m/Y", strtotime($article['date_creation']));

        // Le Badge de validation
        $badgeHtml = "";
        if ($article['statut'] == 1) {
            $badgeHtml = "<div class='stamp-approved'>APPROUVÉ PAR L'ADMIN</div>";
        }

        // 3. Construction HTML avec la nouvelle ligne d'infos (Méta-données)
        $html = <<<HTML
        <div class="article-detail">
            $badgeHtml
            <h1>$titre</h1>
            
            <div class="article-infos">
                <span class="info-auteur">écrit par <strong>$pseudo</strong></span>
                <span class="info-date">le $date</span>
            </div>

            <div class="contenu">$contenu</div>
        </div>
        
        <div class="commentaires-section">
            <h3>Commentaires</h3>
            {$this->getCommentairesHtml()}
        </div>
HTML;
        return $html;
    }

    private function getCommentairesHtml() {
        // --- TRAITEMENT DU FORMULAIRE ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['contenu']) && isset($_SESSION['user_id'])) {
            $contenu = htmlspecialchars($_POST['contenu']);
            $sql = "INSERT INTO commentaires (id_user, id_article, contenu, date_publication) VALUES (?, ?, ?, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$_SESSION['user_id'], $this->id_article, $contenu]);
        }

        // --- AFFICHAGE DES COMMENTAIRES ---
        $html = "";
        
        if (isset($_SESSION['user_id'])) {
            $html .= '
            <form method="post" action="">
                <textarea name="contenu" rows="4" placeholder="Écrivez votre réponse au tableau..." required></textarea>
                <button type="submit" class="btn-craie">Envoyer</button>
            </form>';
        } else {
            $html .= '<p><a href="?page=login">Connectez-vous</a> pour écrire au tableau.</p>';
        }

        $sql = "SELECT c.*, u.pseudo_user FROM commentaires c 
                JOIN users u ON c.id_user = u.id_user 
                WHERE id_article = ? ORDER BY date_publication DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->id_article]);
        $coms = $stmt->fetchAll();

        if (empty($coms)) {
            $html .= "<p style='color:#ccc; font-style:italic; margin-top:20px;'>Le tableau est vide... Soyez le premier !</p>";
        } else {
            foreach ($coms as $c) {
                $date = date("d/m H:i", strtotime($c['date_publication']));
                $pseudo = htmlspecialchars($c['pseudo_user']);
                $txt = nl2br(htmlspecialchars($c['contenu']));
                
                $html .= "
                <div class='com'>
                    <div class='com-header'>
                        <strong>$pseudo</strong> <span style='font-size:0.8rem; color:#aaa;'>($date)</span>
                    </div>
                    <p>$txt</p>
                </div>";
            }
        }
        return $html;
    }
}
?>