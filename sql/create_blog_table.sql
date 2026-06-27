-- Table pour les articles de blog
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
