CREATE TABLE IF NOT EXISTS promo_emails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    code_promo VARCHAR(20) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    utilise BOOLEAN DEFAULT FALSE,
    INDEX idx_email (email),
    INDEX idx_code (code_promo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
