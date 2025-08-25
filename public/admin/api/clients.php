<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

function json_body() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

try {
if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE user_id=? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
elseif ($method === 'POST') {
    $d = json_body();
    $stmt = $pdo->prepare("INSERT INTO clients (user_id, name, company, email, phone, address) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$user_id, $d['name']??'', $d['company']??null, $d['email']??null, $d['phone']??null, $d['address']??null]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
}
elseif ($method === 'PUT') {
    $d = json_body();
    $stmt = $pdo->prepare("UPDATE clients SET name=?, company=?, email=?, phone=?, address=? WHERE id=? AND user_id=?");
    $stmt->execute([$d['name'], $d['company'], $d['email'], $d['phone'], $d['address'], $d['id'], $user_id]);
    echo json_encode(['success'=>true]);
}
elseif ($method === 'DELETE') {
    // Récupérer l'ID soit depuis l'URL soit depuis le body JSON
    $d = json_body();
    $id = $d['id'] ?? ($_GET['id'] ?? null);

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID manquant pour la suppression']);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM clients WHERE id=? AND user_id=?");
    $stmt->execute([$id, $user_id]);

    echo json_encode(['success'=>true]);
}


else { http_response_code(405); echo json_encode(['error'=>'Méthode non autorisée']); }
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(['error'=>$e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}
