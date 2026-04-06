<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function user(): ?array
    {
        $user = Session::get('user');
        if (!is_array($user)) {
            return null;
        }

        $fingerprint = (string) Session::get('fingerprint', '');
        $currentFingerprint = self::fingerprint();
        if ($fingerprint === '' || !hash_equals($fingerprint, $currentFingerprint)) {
            self::logout();
            return null;
        }

        return $user;
    }

    public static function login(array $user): void
    {
        Session::regenerate();
        Session::put('user', $user);
        Session::put('fingerprint', self::fingerprint());
    }

    public static function requireAdmin(): array
    {
        $user = self::user();
        if ($user === null) {
            header('Location: ' . url('auth.php'));
            exit;
        }

        return $user;
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    private static function fingerprint(): string
    {
        return hash('sha256', (string) ($_SERVER['REMOTE_ADDR'] ?? '') . '|' . (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
    }
}