<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        // Récupère tous les projets de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM projets WHERE user_id = ?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } 
    elseif ($method === 'POST') {
        // Crée un nouveau projet
        $data = json_decode(file_get_contents('php://input'), true);

        $client_id = $data['client_id'] ?? null;
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $status = $data['status'] ?? 'en cours';
        $deadline = $data['deadline'] ?? null;

        $stmt = $pdo->prepare("
            INSERT INTO projets (user_id, client_id, title, description, status, created_at, updated_at, deadline)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?)
        ");
        $stmt->execute([$user_id, $client_id, $title, $description, $status, $deadline]);

        echo json_encode([
            'id' => $pdo->lastInsertId(),
            'user_id' => $user_id,
            'client_id' => $client_id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'deadline' => $deadline
        ]);
    } 
    elseif ($method === 'PUT') {
        // Met à jour un projet existant
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'] ?? null;
        $client_id = $data['client_id'] ?? null;
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $status = $data['status'] ?? 'en cours';
        $deadline = $data['deadline'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare("
                UPDATE projets 
                SET client_id=?, title=?, description=?, status=?, updated_at=NOW(), deadline=?
                WHERE id=? AND user_id=?
            ");
            $stmt->execute([$client_id, $title, $description, $status, $deadline, $id, $user_id]);
        }

        echo json_encode([
            'id' => $id,
            'user_id' => $user_id,
            'client_id' => $client_id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'deadline' => $deadline
        ]);
    } 
    elseif ($method === 'DELETE') {
        // Supprime un projet
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM projets WHERE id=? AND user_id=?");
            $stmt->execute([$id, $user_id]);
        }

        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
