<?php
declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    public static function getToken(): string
    {
        if (!Session::has('_csrf')) {
            Session::put('_csrf', Security::token());
        }

        return (string) Session::get('_csrf');
    }

    public static function validate(?string $token): bool
    {
        $sessionToken = (string) Session::get('_csrf', '');
        return $token !== null && $sessionToken !== '' && hash_equals($sessionToken, $token);
    }
}