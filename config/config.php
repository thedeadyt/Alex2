<?php
// config/config.php

// Détecter l'environnement
$isLocal = (strpos($_SERVER['HTTP_HOST'], 'dev.alex2-server.fr') !== false);

// Racine publique du site
define('BASE_URL', $isLocal ? '/Alex2/' : '/');

// Point d'accès API (à adapter selon ton arborescence serveur)
define('API_URL', BASE_URL . 'admin/api');
