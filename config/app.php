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
    ],
    'session' => [
        'name' => 'volunteers_secure',
        'lifetime' => 7200,
        'secure' => true,
        'same_site' => 'Lax',
    ],
];