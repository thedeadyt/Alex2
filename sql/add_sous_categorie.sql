-- Ajouter la colonne sous_categorie à la table blog
ALTER TABLE blog ADD COLUMN sous_categorie VARCHAR(100) DEFAULT NULL AFTER categorie;

-- Créer un index pour améliorer les performances de recherche
CREATE INDEX idx_sous_categorie ON blog(sous_categorie);
