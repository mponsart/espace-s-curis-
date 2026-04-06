<?php
declare(strict_types=1);

use App\Core\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/Core/helpers.php';

$app = new App(dirname(__DIR__));
$app->boot();

return $app;