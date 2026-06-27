-- Mise à jour de la table blog pour supprimer "Articles récents" des catégories
ALTER TABLE blog MODIFY COLUMN categorie ENUM('Tutoriels', 'Actualités Tech') NOT NULL;

-- Migrer les articles "Articles récents" vers "Tutoriels" par défaut
UPDATE blog SET categorie = 'Tutoriels' WHERE categorie = 'Articles récents';
