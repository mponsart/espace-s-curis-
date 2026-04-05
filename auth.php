<?php
/**
 * Middleware d'authentification
 * Inclure ce fichier au début de chaque page protégée
 */

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Page de login
    if (basename($_SERVER['PHP_SELF']) === 'index.php') {
        return; // Laisser passer pour afficher le bouton de connexion
    }
    
    // Rediriger vers la page de connexion
    header('Location: /');
    exit;
}

// Rafraîchir le token si nécessaire
$config = require __DIR__ . '/config.php';

// Vérifier l'expiration du token
if (isset($_SESSION['user']['token']['expires_in'])) {
    $tokenCreated = $_SESSION['user']['token_created'] ?? 0;
    $expiresIn = $_SESSION['user']['token']['expires_in'];
    
    if (time() > ($tokenCreated + $expiresIn - 300)) {
        // Token expire dans moins de 5 minutes, déconnecter
        session_destroy();
        header('Location: /?expired=1');
        exit;
    }
}
