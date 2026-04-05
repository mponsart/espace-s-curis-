<?php
/**
 * EXEMPLE de configuration Google OAuth + Directory API
 * 
 * Copiez ce fichier en config.php et remplissez vos identifiants :
 * cp config.example.php config.php
 * 
 * OAuth :
 * 1. Allez sur https://console.cloud.google.com/
 * 2. Créez un projet ou sélectionnez-en un existant
 * 3. APIs & Services > Credentials > Create Credentials > OAuth 2.0 Client IDs
 * 4. Type: Web application
 * 5. Authorized redirect URI: https://signatures.groupe-speed.cloud/callback.php
 * 6. Copiez Client ID et Client Secret ci-dessous
 * 
 * Directory API (optionnel, pour récupérer le poste automatiquement) :
 * 1. Activez "Admin SDK API" dans APIs & Services > Library
 * 2. Créez un compte de service avec délégation domain-wide
 * 3. Téléchargez le JSON et placez-le dans service-account.json
 * 4. Autorisez le scope: https://www.googleapis.com/auth/admin.directory.user.readonly
 */

return [
    'google' => [
        'client_id' => 'VOTRE_CLIENT_ID.apps.googleusercontent.com',
        'client_secret' => 'VOTRE_CLIENT_SECRET',
        'redirect_uri' => 'https://signatures.groupe-speed.cloud/callback.php',
        'hosted_domain' => 'groupe-speed.cloud',
        // Pour Directory API (optionnel)
        'service_account_file' => __DIR__ . '/service-account.json',
        'admin_email' => 'admin@groupe-speed.cloud',
    ],
    'company' => [
        'name' => 'Groupe Speed Cloud',
        'domain' => 'groupe-speed.cloud',
        'website' => 'https://groupe-speed.cloud',
        'address' => '10 quai du Moulin, 08600 Givet',
        'logo' => 'https://signatures.groupe-speed.cloud/assets/images/cloudy.png',
    ],
    // Services / Départements
    'services' => [
        '' => 'Aucun (personnel)',
        'direction' => [
            'name' => 'Direction',
            'email' => 'direction@groupe-speed.cloud',
            'phone' => '',
        ],
        'comptabilite' => [
            'name' => 'Comptabilité',
            'email' => 'comptabilite@groupe-speed.cloud',
            'phone' => '',
        ],
        'bureau' => [
            'name' => 'Bureau',
            'email' => 'bureau@groupe-speed.cloud',
            'phone' => '',
        ],
        'support' => [
            'name' => 'Support Technique',
            'email' => 'support@groupe-speed.cloud',
            'phone' => '',
        ],
        'commercial' => [
            'name' => 'Service Commercial',
            'email' => 'commercial@groupe-speed.cloud',
            'phone' => '',
        ],
    ],
];
