-- Mise à jour de la table blog pour permettre n'importe quelle catégorie
-- Convertir la colonne categorie de ENUM en VARCHAR pour permettre des catégories personnalisées
ALTER TABLE blog MODIFY COLUMN categorie VARCHAR(100) NOT NULL;
