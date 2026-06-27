<?php
// config/env.php - Chargement des variables d'environnement

function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser la ligne KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Stocker dans $_ENV et définir avec putenv
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Charger le fichier .env
loadEnv(__DIR__ . '/../public/pages/.env');
