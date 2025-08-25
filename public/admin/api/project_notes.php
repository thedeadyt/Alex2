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
        $stmt = $pdo->prepare("SELECT pn.*, p.title AS project_title FROM project_notes pn 
                               JOIN projects p ON pn.project_id = p.id 
                               WHERE pn.user_id=? ORDER BY pn.created_at DESC");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $d = json_body();
        $stmt = $pdo->prepare("INSERT INTO project_notes (user_id, project_id, content) VALUES (?,?,?)");
        $stmt->execute([$user_id, $d['project_id'] ?? null, $d['content'] ?? '']);
        echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
    }
    elseif ($method === 'PUT') {
        $d = json_body();
        $stmt = $pdo->prepare("UPDATE project_notes SET project_id=?, content=? WHERE id=? AND user_id=?");
        $stmt->execute([$d['project_id'], $d['content'], $d['id'], $user_id]);
        echo json_encode(['success'=>true]);
    }
    elseif ($method === 'DELETE') {
        $d = json_body();
        // On récupère l'ID soit depuis le JSON, soit depuis la query string
        $id = $d['id'] ?? $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requis']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM project_notes WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['success'=>true]);
    }
    else {
        http_response_code(405);
        echo json_encode(['error'=>'Méthode non autorisée']);
    }
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(['error'=>$e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}
