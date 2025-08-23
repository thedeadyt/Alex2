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
        $stmt = $pdo->prepare("SELECT i.*, c.company AS client_name, p.title AS project_name 
                               FROM invoices i 
                               LEFT JOIN clients c ON i.client_id=c.id 
                               LEFT JOIN projects p ON i.project_id=p.id 
                               WHERE i.user_id=?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO invoices (user_id, type, number, client_id, project_id, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $data['type'], $data['number'], $data['client_id'], $data['project_id'], $data['amount'], $data['status']]);
        echo json_encode(['id'=>$pdo->lastInsertId()] + $data);
    }
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE invoices SET type=?, number=?, client_id=?, project_id=?, amount=?, status=? WHERE id=? AND user_id=?");
        $stmt->execute([$data['type'], $data['number'], $data['client_id'], $data['project_id'], $data['amount'], $data['status'], $data['id'], $user_id]);
        echo json_encode($data);
    }
    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id=? AND user_id=?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success'=>true]);
    }
} catch (Exception $e) { echo json_encode(['error'=>$e->getMessage()]); }
