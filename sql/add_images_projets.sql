-- Ajouter une colonne images (JSON) pour stocker plusieurs captures (mockup PC, mobile, etc.)
ALTER TABLE projets ADD COLUMN images JSON DEFAULT NULL AFTER image;
