<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

// Créer le client Google
$client = new Google\Client();
$client->setClientId($config['google']['client_id']);
$client->setClientSecret($config['google']['client_secret']);
$client->setRedirectUri($config['google']['redirect_uri']);

// Récupérer le code d'autorisation
if (!isset($_GET['code'])) {
    header('Location: /');
    exit;
}

try {
    // Échanger le code contre un token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        throw new Exception($token['error_description'] ?? $token['error']);
    }
    
    $client->setAccessToken($token);
    
    // Récupérer les infos utilisateur
    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();
    
    // Vérifier le domaine
    if (!str_ends_with($userInfo->email, '@' . $config['google']['hosted_domain'])) {
        throw new Exception('Accès réservé aux emails @groupe-speed.cloud');
    }
    
    // Parser le nom
    $nameParts = explode(' ', $userInfo->name, 2);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';
    
    // Infos par défaut
    $jobTitle = '';
    $department = '';
    $orgUnit = '';
    
    // Essayer de récupérer les infos depuis Directory API
    try {
        $serviceAccountFile = $config['google']['service_account_file'] ?? '';
        if ($serviceAccountFile && file_exists($serviceAccountFile)) {
            $serviceClient = new Google\Client();
            $serviceClient->setAuthConfig($serviceAccountFile);
            $serviceClient->setSubject($config['google']['admin_email']);
            $serviceClient->addScope(Google\Service\Directory::ADMIN_DIRECTORY_USER_READONLY);
            
            $directory = new Google\Service\Directory($serviceClient);
            $directoryUser = $directory->users->get($userInfo->email);
            
            // Récupérer les infos de l'annuaire
            $orgs = $directoryUser->getOrganizations();
            if ($orgs && count($orgs) > 0) {
                $jobTitle = $orgs[0]['title'] ?? '';
                $department = $orgs[0]['department'] ?? '';
            }
            $orgUnit = $directoryUser->getOrgUnitPath() ?? '';
            
            // Photo de l'utilisateur depuis Directory (meilleure qualité)
            $thumbUrl = $directoryUser->getThumbnailPhotoUrl();
            if ($thumbUrl) {
                $userInfo->picture = $thumbUrl;
            }
        }
    } catch (Exception $e) {
        // Directory API non configurée ou erreur, continuer sans
        error_log('Directory API error: ' . $e->getMessage());
    }
    
    // Stocker en session
    $_SESSION['user'] = [
        'email' => $userInfo->email,
        'name' => $userInfo->name,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'picture' => $userInfo->picture,
        'jobTitle' => $jobTitle,
        'department' => $department,
        'orgUnit' => $orgUnit,
        'token' => $token,
        'token_created' => time(),
    ];
    
    header('Location: /');
    exit;
    
} catch (Exception $e) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Erreur - Signatures</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="min-h-screen bg-gray-900 flex items-center justify-center">
        <div class="text-center">
            <div class="text-red-500 text-6xl mb-4">⚠️</div>
            <h1 class="text-2xl font-bold text-white mb-2">Erreur d'authentification</h1>
            <p class="text-gray-400 mb-6"><?= htmlspecialchars($e->getMessage()) ?></p>
            <a href="/" class="text-purple-400 hover:text-purple-300">← Retour</a>
        </div>
    </body>
    </html>
    <?php
}
