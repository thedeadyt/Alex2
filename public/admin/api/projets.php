<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'Non autorisé']);
    http_response_code(401);
    exit;
}

$user_id = $_SESSION["user_id"];
$method = $_SERVER['REQUEST_METHOD'];

// Fonction pour envoyer une réponse JSON
function sendJson($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

switch($method) {
    case 'GET':
        // Récupérer tous les projets
        $stmt = $pdo->query("SELECT id, nom, annee, type, image, description_courte, description_detaillee, lien FROM projets");
        $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendJson($projets);
        break;

    case 'POST':
        // Ajouter un nouveau projet
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['nom'], $input['annee'], $input['type'])) {
            sendJson(['error' => 'Données manquantes'], 400);
        }

        $stmt = $pdo->prepare("INSERT INTO projets (nom, annee, type, image, description_courte, description_detaillee, lien) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $input['nom'],
            $input['annee'],
            $input['type'],
            $input['image'] ?? '',
            $input['description_courte'] ?? '',
            $input['description_detaillee'] ?? '',
            $input['lien'] ?? ''
        ]);
        sendJson(['success' => true, 'id' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        // Modifier un projet
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendJson(['error' => 'ID manquant'], 400);
        }

        $stmt = $pdo->prepare("UPDATE projets SET nom = ?, annee = ?, type = ?, image = ?, description_courte = ?, description_detaillee = ?, lien = ? WHERE id = ?");
        $stmt->execute([
            $input['nom'] ?? '',
            $input['annee'] ?? '',
            $input['type'] ?? '',
            $input['image'] ?? '',
            $input['description_courte'] ?? '',
            $input['description_detaillee'] ?? '',
            $input['lien'] ?? '',
            $input['id']
        ]);
        sendJson(['success' => true]);
        break;

    case 'DELETE':
        // Supprimer un projet
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id'])) {
            sendJson(['error' => 'ID manquant'], 400);
        }

        $stmt = $pdo->prepare("DELETE FROM projets WHERE id = ?");
        $stmt->execute([$input['id']]);
        sendJson(['success' => true]);
        break;

    default:
        sendJson(['error' => 'Méthode non supportée'], 405);
}
