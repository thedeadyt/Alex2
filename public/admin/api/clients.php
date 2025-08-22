<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

$user_id = $_SESSION["user_id"];
$action = $_GET['action'] ?? '';

if($action == 'get') {
    $stmt = $pdo->prepare("SELECT id, name, company, email, phone, address FROM clients WHERE user_id = ?");
    $stmt->execute([$user_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if($action == 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO clients (user_id, name, company, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $data['name'], $data['company'], $data['email'], $data['phone'], $data['address']]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
}

if($action == 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE clients SET name=?, company=?, email=?, phone=?, address=? WHERE id=? AND user_id=?");
    $stmt->execute([$data['name'],$data['company'],$data['email'],$data['phone'],$data['address'],$data['id'],$user_id]);
    echo json_encode(['success'=>true]);
}

if($action == 'delete') {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM clients WHERE id=? AND user_id=?");
    $stmt->execute([$id,$user_id]);
    echo json_encode(['success'=>true]);
}
