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
        $stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $d = json_body();
        $stmt = $pdo->prepare("INSERT INTO services (name, line1, line2, line3, line4, line5) VALUES (?,?,?,?,?,?)");
        $stmt->execute([
            $d['name'] ?? '',
            $d['line1'] ?? null,
            $d['line2'] ?? null,
            $d['line3'] ?? null,
            $d['line4'] ?? null,
            $d['line5'] ?? null
        ]);
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    }
    elseif ($method === 'PUT') {
        $d = json_body();
        if (!isset($d['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant pour la modification']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE services SET name=?, line1=?, line2=?, line3=?, line4=?, line5=? WHERE id=?");
        $stmt->execute([
            $d['name'] ?? '',
            $d['line1'] ?? null,
            $d['line2'] ?? null,
            $d['line3'] ?? null,
            $d['line4'] ?? null,
            $d['line5'] ?? null,
            $d['id']
        ]);
        echo json_encode(['success' => true]);
    }
    elseif ($method === 'DELETE') {
        // Récupérer l'ID depuis l'URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant pour la suppression']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
