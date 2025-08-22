<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // pour PDF Parser

use Smalot\PdfParser\Parser;

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $parser = new Parser();
    $pdf = $parser->parseFile($_FILES['pdf']['tmp_name']);
    $text = $pdf->getText();

    // Extraction simple, à ajuster selon format PDF
    preg_match('/Facture N°\s*(\S+)/i', $text, $num);
    preg_match('/Montant\s*:\s*([\d,.]+)/i', $text, $amount);
    preg_match('/Client\s*:\s*(.+)/i', $text, $client);

    echo json_encode([
        'type' => 'Facture',
        'number' => $num[1] ?? '',
        'amount' => $amount[1] ?? '',
        'client_id' => '', // tu peux chercher l'ID par nom client dans ta BDD
        'project_id' => '',
        'status' => 'En attente'
    ]);
    exit;
}

// ... ici gérer POST/PUT/DELETE pour CRUD classique comme avant
