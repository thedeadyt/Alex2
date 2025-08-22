<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$user_id = $_SESSION["user_id"];
$action = $_GET['action'] ?? '';

if($action == 'get') {
    $stmt = $pdo->prepare("SELECT id, project_id, content FROM project_notes WHERE user_id = ?");
    $stmt->execute([$user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if($action == 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO project_notes (user_id, project_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $data['project_id'], $data['content']]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
}

if($action == 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE project_notes SET project_id=?, content=? WHERE id=? AND user_id=?");
    $stmt->execute([$data['project_id'],$data['content'],$data['id'],$user_id]);
    echo json_encode(['success'=>true]);
}

if($action == 'delete') {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM project_notes WHERE id=? AND user_id=?");
    $stmt->execute([$id,$user_id]);
    echo json_encode(['success'=>true]);
}
