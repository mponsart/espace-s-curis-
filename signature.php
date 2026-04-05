<?php
session_start();

// Vérifier l'authentification
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    exit('Non autorisé');
}

$config = require __DIR__ . '/config.php';

// Paramètres
$style = $_GET['style'] ?? 'gmail';
$type = $_GET['type'] ?? 'personal';

if ($type === 'service') {
    // Signature de service
    $serviceKey = $_GET['service'] ?? '';
    $services = $config['services'] ?? [];
    
    if (isset($services[$serviceKey]) && is_array($services[$serviceKey])) {
        $service = $services[$serviceKey];
        $name = htmlspecialchars($service['name'] ?? '');
        $email = htmlspecialchars($service['email'] ?? '');
        $job = ''; // Pas de poste pour les services
        $phone = htmlspecialchars($service['phone'] ?? '');
    } else {
        $name = '';
        $email = '';
        $job = '';
        $phone = '';
    }
} else {
    // Signature personnelle
    $name = htmlspecialchars($_GET['name'] ?? $_SESSION['user']['name']);
    $job = htmlspecialchars($_GET['job'] ?? '');
    $email = htmlspecialchars($_GET['email'] ?? $_SESSION['user']['email']);
    $phone = '';
}

// Variables pour les templates
$company = $config['company'];

// Valider le style (sécurité)
$allowedStyles = ['gmail', 'outlook', 'mobile'];
if (!in_array($style, $allowedStyles)) {
    $style = 'gmail';
}

// Charger le template
$templateFile = __DIR__ . "/templates/{$style}.php";
if (!file_exists($templateFile)) {
    $templateFile = __DIR__ . '/templates/gmail.php';
}

include $templateFile;
