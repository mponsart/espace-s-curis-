<?php
/**
 * Configuration Google OAuth
 * 
 * Copiez ce fichier en config.php et remplissez vos identifiants :
 * cp config.example.php config.php
 * 
 * OAuth :
 * 1. Allez sur https://console.cloud.google.com/
 * 2. Créez un projet ou sélectionnez-en un existant
 * 3. APIs & Services > Credentials > Create Credentials > OAuth 2.0 Client IDs
 * 4. Type: Web application
 * 5. Authorized redirect URI: https://sign.groupe-speed.cloud/callback.php
 * 6. Copiez Client ID et Client Secret ci-dessous
 */

return [
    'google' => [
        'client_id' => 'VOTRE_CLIENT_ID.apps.googleusercontent.com',
        'client_secret' => 'VOTRE_CLIENT_SECRET',
        'redirect_uri' => 'https://sign.groupe-speed.cloud/callback.php',
        'hosted_domain' => 'groupe-speed.cloud',
    ],
    'company' => [
        'name' => 'Groupe Speed Cloud',
        'domain' => 'groupe-speed.cloud',
        'website' => 'https://groupe-speed.cloud',
        'address' => '10 quai du Moulin, 08600 Givet',
        'logo' => 'https://sign.groupe-speed.cloud/assets/images/cloudy.png',
    ],
    // Services / Départements
    'services' => [
        '' => 'Aucun (personnel)',
        'direction' => [
            'name' => 'Direction',
            'email' => 'direction@groupe-speed.cloud',
        ],
        'rh' => [
            'name' => 'Ressources Humaines',
            'email' => 'rh@groupe-speed.cloud',
        ],
        'comptabilite' => [
            'name' => 'Comptabilité',
            'email' => 'comptabilite@groupe-speed.cloud',
        ],
        'communication' => [
            'name' => 'Communication',
            'email' => 'communication@groupe-speed.cloud',
        ],
        'bureau' => [
            'name' => 'Bureau',
            'email' => 'bureau@groupe-speed.cloud',
        ],
        'support' => [
            'name' => 'Support Technique',
            'email' => 'support@groupe-speed.cloud',
        ],
    ],
    // Liste des postes disponibles
    'jobs' => [
        '' => '-- Sélectionner un poste --',
        'Président' => 'Président',
        'Co-Président' => 'Co-Président',
        'Vice-Président' => 'Vice-Président',
        'Vice-Présidente' => 'Vice-Présidente',
        'Secrétaire Général' => 'Secrétaire Général',
        'Secrétaire' => 'Secrétaire',
        'Trésorier' => 'Trésorier',
        'Trésorier Adjoint' => 'Trésorier Adjoint',
        'Responsable RH' => 'Responsable RH',
        'Chargé(e) RH' => 'Chargé(e) RH',
        'Responsable Comptabilité' => 'Responsable Comptabilité',
        'Comptable' => 'Comptable',
        'Responsable Communication' => 'Responsable Communication',
        'Chargé(e) de Communication' => 'Chargé(e) de Communication',
        'Responsable Technique' => 'Responsable Technique',
        'Technicien Support' => 'Technicien Support',
        'Administrateur Système' => 'Administrateur Système',
        'Développeur' => 'Développeur',
        'Chef de Projet' => 'Chef de Projet',
        'Bénévole' => 'Bénévole',
        'Stagiaire' => 'Stagiaire',
        '__autre__' => 'Autre...',
    ],
];
