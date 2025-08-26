<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

function json_body() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

try {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM projets ORDER BY annee DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
elseif ($method === 'POST') {
    $uploadDir = __DIR__ . '/../../asset/img/projets/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = '/asset/img/projets/' . $fileName; // Chemin à enregistrer en BDD
        } else {
            http_response_code(500);
            echo json_encode(['error'=>'Erreur lors de l’upload de l’image']);
            exit;
        }
    }

    $nom = $_POST['nom'] ?? '';
    $annee = $_POST['annee'] ?? null;
    $type = $_POST['type'] ?? null;
    $descCourte = $_POST['description_courte'] ?? null;
    $descDetaillee = $_POST['description_detaillee'] ?? null;
    $lien = $_POST['lien'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO projets (nom, annee, type, image, description_courte, description_detaillee, lien) 
                        VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$nom, $annee, $type, $imagePath, $descCourte, $descDetaillee, $lien]);
    echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId(),'image'=>$imagePath]);
}

    elseif ($method === 'PUT') {
        $d = json_body();
        $stmt = $pdo->prepare("UPDATE projets 
                               SET nom=?, annee=?, type=?, image=?, description_courte=?, description_detaillee=?, lien=?
                               WHERE id=?");
        $stmt->execute([
            $d['nom'],
            $d['annee'],
            $d['type'],
            $d['image'],
            $d['description_courte'],
            $d['description_detaillee'],
            $d['lien'],
            $d['id']
        ]);
        echo json_encode(['success'=>true]);
    }
    elseif ($method === 'DELETE') {
        $d = json_body();
        $id = $d['id'] ?? ($_GET['id'] ?? null);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant pour la suppression']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM projets WHERE id=?");
        $stmt->execute([$id]);
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
