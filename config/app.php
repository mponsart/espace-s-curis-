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
        'client_id' => '',
        'client_secret' => '',
        'redirect_uri' => 'https://site.com/callback.php',
        'hosted_domain' => '',
        // Liste blanche optionnelle pour l'admin.
        // Accepte soit "prenom.nom" (partie avant @), soit une adresse complète.
        // Laisser vide [] pour désactiver la restriction.
        'allowed_admins' => [
            // 'prenom.nom',
            // 'prenom.nom@site.com',
        ],
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