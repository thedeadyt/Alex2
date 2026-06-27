<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

function json_body() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

try {
    if ($method === 'GET') {
        // Public: only active testimonials. Admin (?all=1): all testimonials
        $all = isset($_GET['all']) && $_GET['all'] === '1';
        if ($all) {
            $stmt = $pdo->query("SELECT * FROM temoignages ORDER BY date_creation DESC");
        } else {
            $stmt = $pdo->query("SELECT * FROM temoignages WHERE actif = 1 ORDER BY date_creation DESC");
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        $d = json_body();

        $nom = trim($d['nom'] ?? '');
        $entreprise = trim($d['entreprise'] ?? '');
        $texte = trim($d['texte'] ?? '');
        $note = isset($d['note']) ? max(1, min(5, (int)$d['note'])) : 5;

        if (empty($nom) || empty($texte)) {
            http_response_code(400);
            echo json_encode(['error' => 'Le nom et le message sont requis.']);
            exit;
        }

        if (strlen($texte) < 10) {
            http_response_code(400);
            echo json_encode(['error' => 'Le message doit contenir au moins 10 caractères.']);
            exit;
        }

        // New submissions are inactive by default (require admin approval)
        $stmt = $pdo->prepare("INSERT INTO temoignages (nom, entreprise, texte, note, actif) VALUES (?, ?, ?, ?, 0)");
        $stmt->execute([$nom, $entreprise ?: null, $texte, $note]);
        echo json_encode(['success' => true, 'message' => 'Merci pour votre avis ! Il sera publié après validation.']);
    }
    elseif ($method === 'PUT') {
        $d = json_body();
        $id = $d['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }

        // Toggle actif or update fields
        if (isset($d['actif']) && count($d) <= 2) {
            // Simple toggle
            $stmt = $pdo->prepare("UPDATE temoignages SET actif = ? WHERE id = ?");
            $stmt->execute([(int)$d['actif'], $id]);
        } else {
            // Full update
            $stmt = $pdo->prepare("UPDATE temoignages SET nom = ?, entreprise = ?, texte = ?, note = ?, actif = ? WHERE id = ?");
            $stmt->execute([
                $d['nom'] ?? '',
                $d['entreprise'] ?? null,
                $d['texte'] ?? '',
                max(1, min(5, (int)($d['note'] ?? 5))),
                (int)($d['actif'] ?? 1),
                $id
            ]);
        }
        echo json_encode(['success' => true]);
    }
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM temoignages WHERE id = ?");
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
