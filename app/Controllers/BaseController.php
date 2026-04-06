<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Csrf;
use App\Core\View;

abstract class BaseController
{
    public function __construct(protected readonly App $app)
    {
    }

    protected function render(string $view, array $data = [], string $layout = 'layouts/admin'): void
    {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function validateCsrf(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            $this->abort(419, 'Jeton CSRF invalide.');
        }
    }

    protected function abort(int $status, string $message): never
    {
        http_response_code($status);
        View::render('public/error', [
            'pageTitle' => 'Erreur',
            'message' => $message,
        ], 'layouts/public');
        exit;
    }
}