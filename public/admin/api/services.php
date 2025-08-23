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
        $stmt = $pdo->prepare("SELECT * FROM services WHERE user_id=?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO services (user_id, name, line1, line2, line3, line4, line5) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $data['name'], $data['line1'], $data['line2'], $data['line3'], $data['line4'], $data['line5']]);
        echo json_encode(['id'=>$pdo->lastInsertId()] + $data);
    }
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE services SET name=?, line1=?, line2=?, line3=?, line4=?, line5=? WHERE id=? AND user_id=?");
        $stmt->execute([$data['name'], $data['line1'], $data['line2'], $data['line3'], $data['line4'], $data['line5'], $data['id'], $user_id]);
        echo json_encode($data);
    }
    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=? AND user_id=?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success'=>true]);
    }
} catch (Exception $e) { echo json_encode(['error'=>$e->getMessage()]); }
