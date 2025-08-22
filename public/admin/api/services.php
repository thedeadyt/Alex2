<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$action = $_GET['action'] ?? '';

if($action == 'get') {
    $stmt = $pdo->query("SELECT id, name FROM services");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if($action == 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO services (name) VALUES (?)");
    $stmt->execute([$data['name']]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
}

if($action == 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE services SET name=? WHERE id=?");
    $stmt->execute([$data['name'],$data['id']]);
    echo json_encode(['success'=>true]);
}

if($action == 'delete') {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode(['success'=>true]);
}
