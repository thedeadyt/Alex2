<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$user_id = $_SESSION["user_id"];
$action = $_GET['action'] ?? '';

if($action == 'get') {
    $stmt = $pdo->prepare("SELECT id, title, client_id, status FROM projects WHERE user_id = ?");
    $stmt->execute([$user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if($action == 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO projects (user_id, client_id, title, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $data['client_id'], $data['title'], $data['status']]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
}

if($action == 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE projects SET title=?, client_id=?, status=? WHERE id=? AND user_id=?");
    $stmt->execute([$data['title'],$data['client_id'],$data['status'],$data['id'],$user_id]);
    echo json_encode(['success'=>true]);
}

if($action == 'delete') {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id=? AND user_id=?");
    $stmt->execute([$id,$user_id]);
    echo json_encode(['success'=>true]);
}
