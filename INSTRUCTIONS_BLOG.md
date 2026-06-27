# Configuration du Blog

## Étape 1 : Créer la table blog dans la base de données

Exécutez cette commande dans le conteneur Docker :

```bash
docker exec -i php-dev-db mysql -uroot -proot11122005 alex2pro_site < /var/www/html/Alex2/sql/create_blog_table.sql
```

Ou connectez-vous au conteneur et exécutez :

```sql
USE alex2pro_site;

CREATE TABLE IF NOT EXISTS blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    categorie ENUM('Articles récents', 'Tutoriels', 'Actualités Tech') NOT NULL,
    image VARCHAR(255),
    resume TEXT,
    contenu LONGTEXT,
    auteur VARCHAR(100) DEFAULT 'Alex²',
    date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    publie BOOLEAN DEFAULT TRUE,
    INDEX idx_categorie (categorie),
    INDEX idx_date (date_publication)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Articles d'exemple
INSERT INTO blog (titre, slug, categorie, resume, contenu) VALUES
('Bienvenue sur notre blog', 'bienvenue-sur-notre-blog', 'Articles récents',
 'Découvrez notre nouveau blog dédié au développement web dans le 65',
 '<p>Bienvenue sur le blog Alex² ! Nous partageons ici nos connaissances en développement web, des tutoriels et les dernières actualités tech.</p>'),

('Débuter avec React', 'debuter-avec-react', 'Tutoriels',
 'Guide complet pour commencer à développer avec React en 2026',
 '<p>React est une bibliothèque JavaScript pour créer des interfaces utilisateur. Dans ce tutoriel, nous allons voir comment démarrer un projet React.</p>'),

('Les nouveautés PHP 8.3', 'nouveautes-php-8-3', 'Actualités Tech',
 'Découvrez les nouvelles fonctionnalités de PHP 8.3',
 '<p>PHP 8.3 apporte son lot de nouveautés : typage plus strict, nouvelles fonctions, et améliorations de performances.</p>');
```

## Étape 2 : Ajouter la gestion du Blog au dashboard admin

La gestion du blog sera ajoutée au dashboard admin avec les fonctionnalités :
- ✅ Ajouter un article
- ✅ Modifier un article
- ✅ Supprimer un article
- ✅ Upload d'images
- ✅ Choix de catégorie
- ✅ Publier/Dépublier

## Étape 3 : Accéder au blog

URL : `https://dev.alex2-server.fr/Alex2/Blog`

Les visiteurs pourront :
- Voir tous les articles
- Filtrer par catégorie (Articles récents, Tutoriels, Actualités Tech)
- Le filtrage se fait automatiquement côté client (React)
