<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/database.php';

// ⚠️ ici on force user_id=1 (à remplacer par $_SESSION['user_id'] si login actif)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE user_id=?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO clients (user_id, name, company, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $data['name'], $data['company'], $data['email'], $data['phone'], $data['address']]);
        echo json_encode(['id'=>$pdo->lastInsertId(), 'name'=>$data['name'], 'company'=>$data['company'], 'email'=>$data['email'], 'phone'=>$data['phone'], 'address'=>$data['address']]);
    }

    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE clients SET name=?, company=?, email=?, phone=?, address=? WHERE id=? AND user_id=?");
        $stmt->execute([$data['name'], $data['company'], $data['email'], $data['phone'], $data['address'], $data['id'], $user_id]);
        echo json_encode($data);
    }

    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id=? AND user_id=?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success'=>true]);
    }
} catch (Exception $e) {
    echo json_encode(['error'=>$e->getMessage()]);
}
