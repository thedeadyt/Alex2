ALTER TABLE projets ADD COLUMN slug VARCHAR(255) AFTER nom;

UPDATE projets SET slug = LOWER(
    REPLACE(
        REPLACE(
            REPLACE(
                REPLACE(
                    REPLACE(TRIM(nom), ' ', '-'),
                '.', ''),
            "'", ''),
        '/', ''),
    '--', '-')
);

CREATE UNIQUE INDEX idx_slug ON projets(slug);
