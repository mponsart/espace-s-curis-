<?php
declare(strict_types=1);

return [
    'app' => [
        'name' => 'Collecte Benevoles',
        'base_url' => 'https://site.com',
        'timezone' => 'Europe/Paris',
    ],
    'db' => [
        'driver' => 'sqlite',
        'path' => 'database/database.sqlite',
    ],
    'google' => [
        'client_id' => 'VOTRE_CLIENT_ID.apps.googleusercontent.com',
        'client_secret' => 'VOTRE_CLIENT_SECRET',
        'redirect_uri' => 'https://site.com/callback.php',
        'hosted_domain' => '',
    ],
    'mail' => [
        'enabled' => false,
        'from_email' => 'no-reply@site.com',
        'from_name' => 'Collecte Benevoles',
        'smtp' => [
            'host' => 'smtp.site.com',
            'port' => 587,
            'encryption' => 'tls',
            'auth' => true,
            'username' => 'smtp-user@site.com',
            'password' => 'change-me',
        ],
    ],
    'session' => [
        'name' => 'volunteers_secure',
        'lifetime' => 7200,
        'secure' => true,
        'same_site' => 'Lax',
    ],
];