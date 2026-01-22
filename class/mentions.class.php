<?php
class Mentions extends Page {

    protected function getContenu() {
        // On garde le style .article-detail pour le cadre tableau noir
        return <<<HTML
        <div class="article-detail">
            <h1>Mentions Légales</h1>
            
            <div class="contenu">
                <h3>1. Édition du site</h3>
                <p>
                    Le présent site est édité dans le cadre de la SAE 203 par <strong>Digbeu Loic</strong>, étudiant en BUT MMI à l'IUT de Bobigny (Université Sorbonne Paris Nord).<br>
                    Contact : <em>digbeuloicpro@gmail.com</em>
                </p>
                
                <h3>2. Hébergement</h3>
                <p>
                    Le site est hébergé par la société <strong>Alwaysdata</strong>.<br>
                    Adresse : 91 rue du Faubourg Saint-Honoré, 75008 Paris, France.<br>
                    Site web : <a href="https://www.alwaysdata.com" target="_blank" style="color: #4da6ff;">www.alwaysdata.com</a>
                </p>
                
                <h3>3. Propriété intellectuelle</h3>
                <p>
                    Ce site est un projet pédagogique. L'ensemble des textes et du code est la propriété de l'auteur, sauf mention contraire. Les images proviennent de banques d'images libres de droit ou sont utilisées à des fins strictement pédagogiques.
                </p>
                
                <h3>4. Données personnelles (RGPD)</h3>
                <p>
                    Les seules données collectées sont le pseudo et le mot de passe (sécurisé/haché) lors de l'inscription. Ces données sont nécessaires pour accéder aux fonctionnalités communautaires (commentaires) et ne sont jamais transmises à des tiers.<br>
                    Conformément à la loi, vous disposez d'un droit d'accès, de rectification et de suppression de vos données.
                </p>
            </div>
        </div>
HTML;
    }
}
?>