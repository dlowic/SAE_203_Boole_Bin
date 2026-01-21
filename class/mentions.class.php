<?php
class Mentions extends Page {

    protected function getContenu() {
        // On utilise le style .article-detail pour avoir le cadre épais à la craie
        return <<<HTML
        <div class="article-detail">
            <h1>Mentions Légales</h1>
            
            <div class="contenu">
                <h3>1. Éditeur du site</h3>
                <p>Ce site est édité dans le cadre de la SAE 203 par <strong>Digbeu Loic</strong>, étudiant en BUT MMI à l'IUT de Bobigny.</p>
                
                <h3>2. Hébergement</h3>
                <p>Le site est hébergé localement ou sur les serveurs de l'IUT de Bobigny (1 rue de Chablis, 93000 Bobigny).</p>
                
                <h3>3. Propriété intellectuelle</h3>
                <p>L'ensemble des textes et images présents sur ce site (sauf mention contraire) sont la propriété de l'auteur. Les images de fond proviennent de banques d'images libres de droit ou sont utilisées à des fins pédagogiques.</p>
                
                <h3>4. Données personnelles</h3>
                <p>Les seules données collectées sont le pseudo et le mot de passe (crypté) lors de l'inscription, nécessaires pour poster des commentaires. Aucune donnée n'est revendue à des tiers.</p>
            </div>
        </div>
HTML;
    }
}
?>