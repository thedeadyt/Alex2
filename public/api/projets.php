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

function uploadDir() {
    $dir = __DIR__ . '/../asset/img/projets/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    return $dir;
}

function saveBase64Image($base64) {
    if (empty($base64) || strpos($base64, 'data:image') !== 0) return null;
    list($type, $data) = explode(';', $base64);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    $ext = strpos($type, 'jpeg') !== false ? 'jpg' : 'png';
    $fileName = uniqid() . '.' . $ext;
    file_put_contents(uploadDir() . $fileName, $data);
    return '/asset/img/projets/' . $fileName;
}

try {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM projets ORDER BY annee DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$r) {
            $r['images'] = !empty($r['images']) ? json_decode($r['images'], true) : [];
        }
        echo json_encode($rows);
    }

    elseif ($method === 'POST') {
        $dir = uploadDir();

        // Image principale
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $dir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = '/asset/img/projets/' . $fileName;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erreur upload image principale']);
                exit;
            }
        }

        // Images galerie (multi-upload)
        $gallery = [];
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
                if (!empty($_FILES['images']['name'][$i])) {
                    $fn = uniqid() . '_' . basename($_FILES['images']['name'][$i]);
                    if (move_uploaded_file($tmp, $dir . $fn)) {
                        $gallery[] = '/asset/img/projets/' . $fn;
                    }
                }
            }
        }

        $nom = $_POST['nom'] ?? '';
        $annee = $_POST['annee'] ?? null;
        $type = $_POST['type'] ?? null;
        $descCourte = $_POST['description_courte'] ?? null;
        $descDetaillee = $_POST['description_detaillee'] ?? null;
        $lien = $_POST['lien'] ?? null;

        $stmt = $pdo->prepare("INSERT INTO projets (nom, annee, type, image, images, description_courte, description_detaillee, lien)
                            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$nom, $annee, $type, $imagePath, json_encode($gallery), $descCourte, $descDetaillee, $lien]);
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId(), 'image' => $imagePath, 'images' => $gallery]);
    }

    elseif ($method === 'PUT') {
        $d = json_body();

        // Récupérer l'existant
        $stmt = $pdo->prepare("SELECT image, images FROM projets WHERE id = ?");
        $stmt->execute([$d['id']]);
        $projet = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $projet['image'] ?? null;
        $existingGallery = !empty($projet['images']) ? json_decode($projet['images'], true) : [];

        // Nouvelle image principale (base64)
        if (!empty($d['image']) && strpos($d['image'], 'data:image') === 0) {
            $imagePath = saveBase64Image($d['image']);
        }

        // Nouvelles images galerie (base64)
        $gallery = $existingGallery;
        if (!empty($d['new_images']) && is_array($d['new_images'])) {
            foreach ($d['new_images'] as $b64) {
                $path = saveBase64Image($b64);
                if ($path) $gallery[] = $path;
            }
        }

        // Images supprimées
        if (!empty($d['remove_images']) && is_array($d['remove_images'])) {
            foreach ($d['remove_images'] as $rmPath) {
                $fullPath = __DIR__ . '/../' . ltrim($rmPath, '/');
                if (file_exists($fullPath)) unlink($fullPath);
                $gallery = array_values(array_filter($gallery, fn($g) => $g !== $rmPath));
            }
        }

        // Override complet si fourni
        if (isset($d['images']) && is_array($d['images'])) {
            $gallery = $d['images'];
        }

        $stmt = $pdo->prepare("UPDATE projets
            SET nom=?, annee=?, type=?, image=?, images=?, description_courte=?, description_detaillee=?, lien=?
            WHERE id=?");
        $stmt->execute([
            $d['nom'],
            $d['annee'],
            $d['type'],
            $imagePath,
            json_encode($gallery),
            $d['description_courte'],
            $d['description_detaillee'],
            $d['lien'],
            $d['id']
        ]);
        echo json_encode(['success' => true, 'image' => $imagePath, 'images' => $gallery]);
    }

    elseif ($method === 'DELETE') {
        $d = json_body();
        $id = $d['id'] ?? ($_GET['id'] ?? null);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant pour la suppression']);
            exit;
        }

        // Récupérer les images
        $stmt = $pdo->prepare("SELECT image, images FROM projets WHERE id = ?");
        $stmt->execute([$id]);
        $projet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($projet) {
            // Supprimer image principale
            if (!empty($projet['image'])) {
                $path = __DIR__ . '/../' . ltrim($projet['image'], '/');
                if (file_exists($path)) unlink($path);
            }
            // Supprimer images galerie
            $gallery = !empty($projet['images']) ? json_decode($projet['images'], true) : [];
            foreach ($gallery as $img) {
                $path = __DIR__ . '/../' . ltrim($img, '/');
                if (file_exists($path)) unlink($path);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM projets WHERE id = ?");
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
