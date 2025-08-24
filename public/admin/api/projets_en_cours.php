<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/database.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        // Récupère tous les projets de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id=?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validation des champs obligatoires
        if (empty($data['title']) || empty($data['client_id']) || empty($data['status']) || empty($data['deadline'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Tous les champs sont requis']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO projects (title, client_id, status, deadline, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['title'], $data['client_id'], $data['status'], $data['deadline'], $user_id]);

        // Retourne le projet créé
        $data['id'] = $pdo->lastInsertId();
        echo json_encode($data);
    }

    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id']) || empty($data['title']) || empty($data['client_id']) || empty($data['status']) || empty($data['deadline'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Tous les champs sont requis']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE projects SET title=?, client_id=?, status=?, deadline=? WHERE id=? AND user_id=?");
        $stmt->execute([$data['title'], $data['client_id'], $data['status'], $data['deadline'], $data['id'], $user_id]);

        echo json_encode($data);
    }

    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM projects WHERE id=? AND user_id=?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success' => true]);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
