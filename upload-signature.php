<?php
session_start();

// Vérifier l'authentification
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

// Vérifier la méthode
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données
$input = json_decode(file_get_contents('php://input'), true);
$imageData = $input['image'] ?? null;
$filename = $input['filename'] ?? 'signature';

if (!$imageData) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucune image fournie']);
    exit;
}

// Décoder l'image base64
$imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
$imageData = base64_decode($imageData);

if (!$imageData) {
    http_response_code(400);
    echo json_encode(['error' => 'Image invalide']);
    exit;
}

// Créer le dossier uploads s'il n'existe pas
$uploadDir = __DIR__ . '/uploads/signatures/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Générer un nom unique
$uniqueId = uniqid() . '_' . bin2hex(random_bytes(4));
$safeFilename = preg_replace('/[^a-z0-9_-]/i', '_', $filename);
$finalFilename = $safeFilename . '_' . $uniqueId . '.png';
$filePath = $uploadDir . $finalFilename;

// Sauvegarder l'image
if (file_put_contents($filePath, $imageData) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la sauvegarde']);
    exit;
}

// Générer l'URL publique
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$publicUrl = $protocol . '://' . $host . '/uploads/signatures/' . $finalFilename;

// Retourner l'URL
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'url' => $publicUrl,
    'filename' => $finalFilename
]);
