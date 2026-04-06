<?php
declare(strict_types=1);

use App\Core\App;
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Session;

function app(): App
{
    return App::instance();
}

function config(string $key, mixed $default = null): mixed
{
    return app()->config($key, $default);
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    $baseUrl = rtrim((string) config('app.base_url', ''), '/');
    $path = '/' . ltrim($path, '/');

    if ($baseUrl === '') {
        return $path;
    }

    return $path === '/' ? $baseUrl . '/' : $baseUrl . $path;
}

function current_user(): ?array
{
    return Auth::user();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(Csrf::getToken()) . '">';
}

function flash(string $key): mixed
{
    return Session::flash($key);
}

function old(string $key, mixed $default = ''): mixed
{
    $old = Session::get('_old', []);
    return is_array($old) && array_key_exists($key, $old) ? $old[$key] : $default;
}

function remember_old(array $values): void
{
    Session::put('_old', $values);
}

function clear_old(): void
{
    Session::remove('_old');
}