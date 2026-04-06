<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

if (current_user() !== null) {
    header('Location: ' . url('dashboard.php'));
    exit;
}

header('Location: ' . url('auth.php'));
exit;
