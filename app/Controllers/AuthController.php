<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\GoogleOAuth;
use App\Core\Security;
use App\Core\Session;
use App\Models\UserModel;

final class AuthController extends BaseController
{
    private GoogleOAuth $oauth;

    private UserModel $users;

    public function __construct(\App\Core\App $app)
    {
        parent::__construct($app);
        $this->oauth = new GoogleOAuth((array) $this->app->config('google', []));
        $this->users = new UserModel();
    }

    public function login(): never
    {
        if (Auth::user() !== null) {
            $this->redirect('dashboard.php');
        }

        $state = Security::token();
        Session::put('oauth_state', $state);
        header('Location: ' . $this->oauth->createAuthUrl($state));
        exit;
    }

    public function callback(): never
    {
        $state = (string) ($_GET['state'] ?? '');
        $code = (string) ($_GET['code'] ?? '');
        $expectedState = (string) Session::get('oauth_state', '');
        Session::remove('oauth_state');

        if ($state === '' || $code === '' || $expectedState === '' || !hash_equals($expectedState, $state)) {
            $this->abort(400, 'Réponse OAuth invalide.');
        }

        $profile = $this->oauth->fetchUser($code);
        $hostedDomain = trim((string) $this->app->config('google.hosted_domain', ''));
        if ($hostedDomain !== '') {
            $emailDomain = (string) substr(strrchr($profile['email'], '@') ?: '', 1);
            if (strcasecmp($emailDomain, $hostedDomain) !== 0) {
                $this->abort(403, 'Adresse Google non autorisée.');
            }
        }

        $user = $this->users->findByEmail($profile['email']);
        if ($user === null) {
            $user = $this->users->create($profile['name'], $profile['email'], $profile['avatar']);
        } else {
            $this->users->updateProfile((int) $user['id'], $profile['name'], $profile['avatar']);
            $user = $this->users->findByEmail($profile['email']) ?? $user;
        }

        Auth::login($user);
        Session::flash('success', 'Connexion Google réussie.');
        $this->redirect('dashboard.php');
    }

    public function logout(): never
    {
        Auth::logout();
        $this->redirect('auth.php');
    }
}