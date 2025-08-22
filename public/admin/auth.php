<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: " . BASE_URL . "/login");
    exit;
}

// Si connecté → on inclut la vraie page demandée
$requested = $_SERVER["REQUEST_URI"];

// Exemple : /admin/dashboard
$file = __DIR__ . parse_url($requested, PHP_URL_PATH);

// Si c’est un fichier existant → on l’ouvre
if (file_exists($file) && is_file($file)) {
    include $file;
} else {
    include __DIR__ . "/404.php"; // optionnel, page 404 admin
}
