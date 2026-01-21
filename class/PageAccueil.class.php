<?php
class PageAccueil extends Page {

    protected function getContenu() {
        // --- SECTION 1 : Les Cours Officiels ---
        $html = '<h2 class="section-title">Les Cours Officiels</h2>';
        $html .= '<div class="accueil-grid">';
        
        $sql = "SELECT a.*, m.url, m.type FROM articles a 
                LEFT JOIN media m ON a.id_article = m.id_article 
                WHERE a.statut = 1 AND a.id_user IS NULL";
        $stmt = $this->pdo->query($sql);
        $html .= $this->genererCartes($stmt->fetchAll());
        $html .= '</div>';

        // --- SECTION 2 : La Communauté ---
        $sqlComm = "SELECT a.*, u.pseudo_user FROM articles a 
                    JOIN users u ON a.id_user = u.id_user 
                    WHERE a.statut = 1 ORDER BY a.date_creation DESC";
        $stmtComm = $this->pdo->query($sqlComm);
        $articlesComm = $stmtComm->fetchAll();

        if (!empty($articlesComm)) {
            $html .= '<h2 class="section-title" style="margin-top:50px; color:#f1c40f;">Articles de la Communauté</h2>';
            $html .= '<div class="accueil-grid">';
            
            foreach ($articlesComm as $art) {
                $titre = htmlspecialchars($art['titre']);
                $resume = htmlspecialchars($art['resume']);
                $pseudo = htmlspecialchars($art['pseudo_user']);
                
                // Formatage de la date (ex: 20/01/2026)
                $date = date("d/m/Y", strtotime($art['date_creation']));
                
                $html .= <<<HTML
                <div class="article community-card">
                    <a href="?page=article&id={$art['id_article']}">
                        <div class="card-header">
                            <span class="badge-comm">Par $pseudo</span>
                            <span class="date-comm">le $date</span>
                        </div>
                        
                        <h2>$titre</h2>
                        <div class="card-body">
                            <p>$resume</p>
                        </div>
                    </a>
                </div>
HTML;
            }
            $html .= '</div>';
        }

        return $html;
    }

    private function genererCartes($articles) {
        $out = "";
        foreach ($articles as $art) {
            $titre = htmlspecialchars($art['titre']);
            $resume = htmlspecialchars($art['resume']);
            $mediaHtml = '';
            
            // On ajoute une classe placeholder si pas d'image pour garder la taille
            $imgClass = "illustration";
            if (!empty($art['url']) && $art['type'] == 'image') {
                $mediaHtml = "<img src='{$art['url']}' alt='$titre' class='$imgClass'>";
            } else {
                // Espace vide pour aligner les cartes si pas d'image
                $mediaHtml = "<div class='illustration-placeholder'></div>";
            }

            $out .= <<<HTML
            <div class="article">
                <a href="?page=article&id={$art['id_article']}">
                    $mediaHtml
                    <h2>$titre</h2>
                    <div class="card-body">
                        <p>$resume</p>
                    </div>
                </a>
            </div>
HTML;
        }
        return $out;
    }
}
?>