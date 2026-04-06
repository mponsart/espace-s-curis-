<?php
declare(strict_types=1);

$app = require __DIR__ . '/app/bootstrap.php';

(new App\Controllers\AdminController($app))->invite();