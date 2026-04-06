# Collecte Bénévoles (PHP 8.3)

Application web simple et sécurisée pour collecter les informations de bénévoles.

## Stack

- PHP natif 8.3
- SQLite + PDO (requêtes préparées)
- Google OAuth 2.0 avec `google/apiclient`
- Tailwind CSS via CDN
- Architecture simple type MVC (`app/`, `config/`, points d'entrée racine)

## Fonctionnalités

- Connexion admin uniquement via Google OAuth
- Création automatique d'un utilisateur admin si email inconnu
- Dashboard admin
- Gestion des bénévoles : liste, détail, suppression
- Invitation par lien sécurisé (token 64 chars, expiration 7 jours)
- Formulaire public : `/form.php?token=...`
- Validation serveur + CSRF + consentement RGPD obligatoire
- Export CSV
- Headers de sécurité (X-Frame-Options, X-XSS-Protection, CSP)

## Prérequis

- PHP `>= 8.3`
- Extension PHP `pdo_sqlite`
- Composer
- Un projet Google Cloud avec OAuth Web App

## Installation

1. Installer les dépendances PHP :

```bash
composer install
composer dump-autoload
```

2. Initialiser SQLite :

```bash
mkdir -p database
touch database/database.sqlite
sqlite3 database/database.sqlite < database/schema.sql
```

3. Configurer l'application dans `config/app.php` :

- `app.base_url` : URL publique du site (ex: `https://site.com`)
- `db.driver` : laisser `sqlite`
- `db.path` : chemin vers le fichier SQLite (ex: `database/database.sqlite`)
- `google.client_id` et `google.client_secret`
- `google.redirect_uri` : doit pointer vers `/callback.php`
- `google.hosted_domain` : laisser vide pour autoriser tous les domaines Google, ou définir un domaine précis

4. Vérifier que l'hôte web pointe vers la racine du projet et que `mod_rewrite` est actif (Apache).

## Installation sur cPanel

Ce guide fonctionne sur un hébergement cPanel classique (Apache + PHP + SQLite).

### 1) Créer le domaine ou sous-domaine

1. Dans cPanel, ouvrir **Domains**.
2. Créer le domaine/sous-domaine (ex: `benevoles.votredomaine.com`).
3. Noter le **Document Root** (souvent `public_html/...`).

### 2) Régler PHP 8.3

1. Ouvrir **MultiPHP Manager**.
2. Affecter PHP `8.3` au domaine.
3. Vérifier les extensions actives : `pdo_sqlite`, `mbstring`, `json`, `openssl`.

### 3) Déployer les fichiers

Option A (recommandée) : via Git ou SSH + Composer.

```bash
cd ~/public_html/votre-dossier
git clone <votre-repo> .
composer install --no-dev --optimize-autoloader
```

Option B (sans SSH) : via File Manager.

1. Zip du projet en local (inclure `vendor/` si Composer indisponible côté serveur).
2. Upload dans le Document Root.
3. Extract dans le bon dossier.

### 4) Créer la base SQLite

Avec SSH :

```bash
cd ~/public_html/votre-dossier
mkdir -p database
touch database/database.sqlite
sqlite3 database/database.sqlite < database/schema.sql
```

Sans SSH :

1. Créer le fichier `database/database.sqlite` via **File Manager**.
2. Laisser l'application l'initialiser automatiquement au premier accès (si le fichier est vide).

### 5) Configurer l'application

Éditer `config/app.php` avec les valeurs cPanel :

- `app.base_url` : `https://votre-domaine.com`
- `db.driver` : `sqlite`
- `db.path` : `database/database.sqlite`
- `google.redirect_uri` : `https://votre-domaine.com/callback.php`

### 6) Configurer OAuth Google pour le domaine de prod

Dans Google Cloud Console > OAuth Client ID :

- Authorized redirect URI : `https://votre-domaine.com/callback.php`

La valeur doit correspondre exactement à `google.redirect_uri`.

### 7) Droits fichiers/dossiers

- Dossiers : `755`
- Fichiers : `644`
- Dossier `uploads/` : écriture autorisée par le serveur web

### 8) Vérification post-déploiement

1. Ouvrir `https://votre-domaine.com/auth.php`
2. Se connecter avec Google
3. Ouvrir `invite.php` et générer un lien
4. Ouvrir le lien `form.php?token=...`
5. Vérifier dans `database/database.sqlite` l'enregistrement des données

### 9) Checklist de production

- Forcer HTTPS activé
- `SESSION_SECURE` logique via HTTPS (déjà géré par l'app)
- Sauvegardes régulières du fichier `database/database.sqlite` + fichiers
- Vérifier les erreurs Apache/PHP dans **Metrics > Errors**
- Conserver `.htaccess` en place (headers sécurité)

## Configuration Google OAuth

1. Ouvrir Google Cloud Console
2. Créer un projet (ou utiliser un existant)
3. Activer l'API Google Identity (OAuth)
4. Créer des identifiants OAuth 2.0 (type Web Application)
5. Ajouter l'URI de redirection autorisée :

- `https://site.com/callback.php`

6. Copier Client ID / Client Secret dans `config/app.php`

## Lancement en local

En local simple :

```bash
php -S localhost:8000
```

Puis ouvrir :

- `http://localhost:8000/auth.php` (connexion Google)
- `http://localhost:8000/dashboard.php` (admin)

Important : pour OAuth Google, la redirection doit correspondre exactement à l'URL configurée côté Google.

## Routes principales

### Auth

- `index.php` → redirection vers auth/dashboard
- `auth.php` → redirection OAuth Google
- `callback.php` → callback OAuth
- `logout.php` → déconnexion

### Admin

- `dashboard.php`
- `volunteers.php`
- `volunteer.php?id=123`
- `invite.php`
- `delete-volunteer.php` (POST)
- `export-volunteers.php`

### Public

- `form.php?token=...`

## Flux d'utilisation

1. Un admin se connecte via Google
2. Dans `invite.php`, il saisit un email et génère un lien
3. Le lien contient un token unique expirant sous 7 jours
4. Le bénévole remplit le formulaire public
5. Les données sont validées et enregistrées en base
6. L'admin retrouve la fiche dans `volunteers.php`

## Sécurité implémentée

- Sessions sécurisées (`httponly`, `samesite`, `secure`)
- `session_regenerate_id(true)` à la connexion
- Fingerprint de session (IP + User-Agent)
- CSRF token sur les formulaires sensibles
- Requêtes SQL préparées PDO
- Échappement HTML avec `htmlspecialchars` via helper `e()`
- Validation serveur stricte du formulaire public
- Vérification token + expiration pour l'accès public
- Headers de sécurité via `.htaccess` + bootstrap

## Schéma SQL

Le schéma est dans :

- `database/schema.sql`

Tables :

- `users` : admins Google
- `volunteers` : invitations + fiches bénévoles

Note : le schéma est écrit pour SQLite.

## Structure du projet

```text
app/
  Controllers/
  Core/
  Models/
  Views/
config/
  app.php
  app.example.php
database/
  schema.sql
*.php (routes racine)
```

## Charte graphique

L'interface actuelle suit une direction SaaS propre, responsive, avec Tailwind CDN et palette bleu/cyan.

Si vous voulez l'aligner strictement sur votre charte :

1. Modifier la palette admin dans `app/Views/layouts/admin.php` (bloc `tailwind.config.extend.colors`).
2. Modifier la palette publique dans `app/Views/layouts/public.php`.
3. Mettre à jour les accents de composants dans :
  - `app/Views/admin/dashboard.php`
  - `app/Views/admin/volunteers.php`
  - `app/Views/admin/invite.php`
  - `app/Views/public/form.php`
4. Adapter la typographie dans les layouts (`fontFamily`).

Conseil : centraliser vos couleurs de charte dans les layouts, puis ne réutiliser que ces tokens dans les vues.

## Vérification rapide

Vérifier la syntaxe PHP :

```bash
find app -name '*.php' -print | xargs -I{} php -l '{}'
php -l index.php auth.php callback.php logout.php dashboard.php volunteers.php volunteer.php invite.php delete-volunteer.php export-volunteers.php form.php
```

## Dépannage

- Erreur OAuth : vérifier `google.redirect_uri` (exact match avec Google Cloud)
- Redirection infinie vers login : vérifier `config/app.php` et session PHP
- Erreur DB : vérifier `pdo_sqlite`, droits d'ecriture et présence de `database/database.sqlite`
- Token invalide : vérifier la date système serveur + expiration `token_expires_at`

## Notes

- `config.example.php` (racine) est historique.
- La configuration active de l'application est `config/app.php`.
- Pour une nouvelle installation, partir de `config/app.example.php`.
