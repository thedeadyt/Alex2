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
        $stmt = $pdo->prepare("SELECT n.*, p.title AS project_name FROM project_notes n 
                               JOIN projects p ON n.project_id=p.id WHERE n.user_id=?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO project_notes (user_id, project_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $data['project_id'], $data['content']]);
        echo json_encode(['id'=>$pdo->lastInsertId()] + $data);
    }
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE project_notes SET project_id=?, content=? WHERE id=? AND user_id=?");
        $stmt->execute([$data['project_id'], $data['content'], $data['id'], $user_id]);
        echo json_encode($data);
    }
    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("DELETE FROM project_notes WHERE id=? AND user_id=?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success'=>true]);
    }
} catch (Exception $e) { echo json_encode(['error'=>$e->getMessage()]); }
