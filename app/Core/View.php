<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'layouts/public'): void
    {
        $viewsPath = App::instance()->basePath('app/Views');
        $viewFile = $viewsPath . '/' . $view . '.php';
        $layoutFile = $viewsPath . '/' . $layout . '.php';

        if (!is_file($viewFile) || !is_file($layoutFile)) {
            throw new RuntimeException('Vue ou layout introuvable.');
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();
        require $layoutFile;
    }
}