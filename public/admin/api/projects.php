<?php
session_start();
header('Content-Type: application/json');

// ⚠️ Ajuste ce chemin selon ton arborescence
require_once __DIR__ . '/../../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$method  = $_SERVER['REQUEST_METHOD'];

// 🔹 Lecture des données (support JSON + form-urlencoded)
$getData = function () {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (is_array($data)) return $data; // ✅ JSON

    parse_str($raw, $formData);
    if (!empty($formData)) return $formData; // ✅ FormData

    return []; // rien reçu
};

// Validation & helpers
$allowedStatus = ['À faire','En cours','Terminé'];
$fields = ['client_id','title','description','status','deadline'];

function is_valid_date($s) {
    if ($s === null || $s === '') return true;
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $s) === 1 || preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $s) === 1;
}

function client_belongs_to_user(PDO $pdo, $client_id, $user_id) {
    $st = $pdo->prepare("SELECT 1 FROM clients WHERE id = ? AND user_id = ?");
    $st->execute([$client_id, $user_id]);
    return (bool)$st->fetchColumn();
}

// 🔹 Normalise la date si format DD/MM/YYYY
function normalize_deadline(&$data) {
    if (!empty($data['deadline'])) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['deadline'])) return;
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data['deadline'])) {
            [$d,$m,$y] = explode('/', $data['deadline']);
            $data['deadline'] = "$y-$m-$d";
        }
    }
}

try {
    // ================= GET =================
    if ($method === 'GET') {
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = (int) $_GET['id'];
            $sql = "SELECT p.id, p.client_id, p.title, p.description, p.status, p.deadline,
                           p.created_at, p.updated_at, c.name AS client_name
                    FROM projects p
                    JOIN clients c ON c.id = p.client_id
                    WHERE p.id = ? AND p.user_id = ?";
            $st = $pdo->prepare($sql);
            $st->execute([$id, $user_id]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if (!$row) { http_response_code(404); echo json_encode(['error'=>'Introuvable']); exit; }
            echo json_encode($row);
        } else {
            $sql = "SELECT p.id, p.client_id, p.title, p.description, p.status, p.deadline,
                           p.created_at, p.updated_at, c.name AS client_name
                    FROM projects p
                    JOIN clients c ON c.id = p.client_id
                    WHERE p.user_id = ?
                    ORDER BY p.created_at DESC, p.id DESC";
            $st = $pdo->prepare($sql);
            $st->execute([$user_id]);
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        }
        exit;
    }

    // ================= POST =================
    if ($method === 'POST' && ($_POST['_method'] ?? '') !== 'PUT' && ($_POST['_method'] ?? '') !== 'DELETE') {
        $data = $getData();
        normalize_deadline($data);

        if (empty($data['title']) || empty($data['client_id']) || !ctype_digit((string)$data['client_id'])) {
            http_response_code(422);
            echo json_encode(['error'=>'Champs requis: title, client_id (numérique).', 'received'=>$data]);
            exit;
        }
        if (!client_belongs_to_user($pdo, (int)$data['client_id'], $user_id)) {
            http_response_code(403);
            echo json_encode(['error'=>"client_id invalide pour cet utilisateur.", 'received'=>$data]);
            exit;
        }

        $status = $data['status'] ?? 'À faire';
        if (!in_array($status, $allowedStatus, true)) {
            http_response_code(422);
            echo json_encode(['error'=>'status invalide.', 'received'=>$data]);
            exit;
        }

        $deadline = $data['deadline'] ?? null;
        if (!is_valid_date($deadline)) {
            http_response_code(422);
            echo json_encode(['error'=>'deadline invalide (attendu: YYYY-MM-DD ou DD/MM/YYYY).', 'received'=>$data]);
            exit;
        }

        $sql = "INSERT INTO projects (user_id, client_id, title, description, status, deadline)
                VALUES (?, ?, ?, ?, ?, ?)";
        $st = $pdo->prepare($sql);
        $st->execute([
            $user_id,
            (int)$data['client_id'],
            $data['title'],
            $data['description'] ?? null,
            $status,
            $deadline ?: null
        ]);

        $id = (int)$pdo->lastInsertId();
        http_response_code(201);
        echo json_encode(['id'=>$id] + array_intersect_key($data, array_flip($fields)));
        exit;
    }

    // ================= PUT =================
    if ($method === 'PUT' || ($_POST['_method'] ?? '') === 'PUT') {
        $data = $getData();
        normalize_deadline($data);

        // 🔹 récupérer l'id depuis query string si présent
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) $data['id'] = (int)$_GET['id'];

        if (empty($data['id']) || !ctype_digit((string)$data['id'])) {
            http_response_code(422);
            echo json_encode(['error'=>'Paramètre "id" invalide.', 'received'=>$data]);
            exit;
        }
        $id = (int)$data['id'];

        $sets = [];
        $params = [];

        if (array_key_exists('client_id', $data)) {
            if (!ctype_digit((string)$data['client_id']) || !client_belongs_to_user($pdo, (int)$data['client_id'], $user_id)) {
                http_response_code(403);
                echo json_encode(['error'=>'client_id invalide pour cet utilisateur.', 'received'=>$data]);
                exit;
            }
            $sets[] = "client_id = ?";
            $params[] = (int)$data['client_id'];
        }

        if (array_key_exists('title', $data))   { $sets[] = "title = ?";       $params[] = $data['title']; }
        if (array_key_exists('description',$data)) { $sets[] = "description = ?"; $params[] = $data['description']; }

        if (array_key_exists('status',$data)) {
            if (!in_array($data['status'], $allowedStatus, true)) {
                http_response_code(422);
                echo json_encode(['error'=>'status invalide.', 'received'=>$data]);
                exit;
            }
            $sets[] = "status = ?";
            $params[] = $data['status'];
        }

        if (array_key_exists('deadline',$data)) {
            if (!is_valid_date($data['deadline'])) {
                http_response_code(422);
                echo json_encode(['error'=>'deadline invalide (attendu: YYYY-MM-DD ou DD/MM/YYYY).', 'received'=>$data]);
                exit;
            }
            $sets[] = "deadline = ?";
            $params[] = $data['deadline'] ?: null;
        }

        if (empty($sets)) {
            http_response_code(422);
            echo json_encode(['error'=>'Aucun champ à mettre à jour.', 'received'=>$data]);
            exit;
        }

        $sql = "UPDATE projects SET ".implode(', ', $sets)." WHERE id = ? AND user_id = ?";
        $params[] = $id;
        $params[] = $user_id;

        $st = $pdo->prepare($sql);
        $st->execute($params);

        echo json_encode(['success'=>true, 'id'=>$id]);
        exit;
    }

    // ================= DELETE =================
    if ($method === 'DELETE' || ($_POST['_method'] ?? '') === 'DELETE') {
        $data = $getData();

        // 🔹 récupérer l'id depuis le body ou query string
        $id = null;
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) $id = (int)$_GET['id'];
        elseif (!empty($data['id']) && ctype_digit((string)$data['id'])) $id = (int)$data['id'];

        if (!$id) {
            http_response_code(422);
            echo json_encode(['error'=>'Paramètre "id" invalide.', 'received'=>$data]);
            exit;
        }

        $st = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
        $st->execute([$id, $user_id]);

        echo json_encode(['success'=>true]);
        exit;
    }

    http_response_code(405);
    header('Allow: GET, POST, PUT, DELETE');
    echo json_encode(['error'=>'Méthode non autorisée']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
