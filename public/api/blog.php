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

function generateSlug($titre) {
    $slug = strtolower(trim($titre));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

try {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM blog ORDER BY date_publication DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    elseif ($method === 'POST') {
        // Gérer à la fois FormData et JSON
        $isJson = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;

        if ($isJson) {
            // Données JSON (article sans nouvelle image)
            $d = json_body();
            $titre = $d['titre'] ?? '';
            $slug = generateSlug($titre);
            $categorie = !empty($d['categorie']) ? $d['categorie'] : 'Non catégorisé';
            $sous_categorie = $d['sous_categorie'] ?? null;
            $resume = $d['resume'] ?? null;
            $contenu = $d['contenu'] ?? null;
            $auteur = $d['auteur'] ?? 'Alex²';
            $publie = isset($d['publie']) ? (int)$d['publie'] : 1;
            $imagePath = $d['image'] ?? null; // Image existante si modification
        } else {
            // Données FormData (avec upload d'image)
            $uploadDir = __DIR__ . '/../asset/img/blog/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $imagePath = null;
            if (!empty($_FILES['image']['name'])) {
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = '/asset/img/blog/' . $fileName;
                } else {
                    http_response_code(500);
                    echo json_encode(['error'=>'Erreur lors de l\'upload de l\'image']);
                    exit;
                }
            }

            $titre = $_POST['titre'] ?? '';
            $slug = generateSlug($titre);
            $categorie = !empty($_POST['categorie']) ? $_POST['categorie'] : 'Non catégorisé';
            $sous_categorie = $_POST['sous_categorie'] ?? null;
            $resume = $_POST['resume'] ?? null;
            $contenu = $_POST['contenu'] ?? null;
            $auteur = $_POST['auteur'] ?? 'Alex²';
            $publie = isset($_POST['publie']) ? (int)$_POST['publie'] : 1;
        }

        $stmt = $pdo->prepare("INSERT INTO blog (titre, slug, categorie, sous_categorie, image, resume, contenu, auteur, publie)
                            VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$titre, $slug, $categorie, $sous_categorie, $imagePath, $resume, $contenu, $auteur, $publie]);
        echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId(),'image'=>$imagePath,'slug'=>$slug]);
    }
    elseif ($method === 'PUT') {
        $d = json_body();

        // Récupérer l'ancienne image
        $stmt = $pdo->prepare("SELECT image FROM blog WHERE id = ?");
        $stmt->execute([$d['id']]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $article['image'] ?? null;

        // Si une nouvelle image est fournie (base64)
        if (!empty($d['image']) && strpos($d['image'], 'data:image') === 0) {
            $data = $d['image'];
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            $ext = strpos($type,'jpeg')!==false?'jpg':'png';
            $fileName = uniqid() . '.' . $ext;
            $uploadDir = __DIR__ . '/../asset/img/blog/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            file_put_contents($uploadDir.$fileName, $data);
            $imagePath = '/asset/img/blog/' . $fileName;
        }

        $slug = !empty($d['titre']) ? generateSlug($d['titre']) : $article['slug'];

        $stmt = $pdo->prepare("UPDATE blog
            SET titre=?, slug=?, categorie=?, sous_categorie=?, image=?, resume=?, contenu=?, auteur=?, publie=?
            WHERE id=?");
        $stmt->execute([
            $d['titre'],
            $slug,
            $d['categorie'],
            $d['sous_categorie'] ?? null,
            $imagePath,
            $d['resume'],
            $d['contenu'],
            $d['auteur'] ?? 'Alex²',
            $d['publie'] ?? 1,
            $d['id']
        ]);
        echo json_encode(['success'=>true, 'image'=>$imagePath, 'slug'=>$slug]);
    }
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID manquant pour la suppression']);
            exit;
        }

        // Récupérer et supprimer l'image
        $stmt = $pdo->prepare("SELECT image FROM blog WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article && !empty($article['image'])) {
            $imagePath = __DIR__ . '/../' . ltrim($article['image'], '/');
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = ?");
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
