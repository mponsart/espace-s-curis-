<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use RuntimeException;

final class App
{
    private static ?self $instance = null;

    private array $config = [];

    private ?PDO $db = null;

    public function __construct(private readonly string $basePath)
    {
        self::$instance = $this;
    }

    public function boot(): void
    {
        $configFile = $this->basePath . '/config/app.php';
        if (!is_file($configFile)) {
            throw new RuntimeException('Le fichier de configuration config/app.php est introuvable.');
        }

        $this->config = require $configFile;
        date_default_timezone_set((string) $this->config('app.timezone', 'Europe/Paris'));
        Session::start((array) $this->config('session', []));
        Security::applyHeaders();
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            throw new RuntimeException('Application non initialisee.');
        }

        return self::$instance;
    }

    public function config(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = $this->config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    public function db(): PDO
    {
        if ($this->db === null) {
            $this->db = Database::connect((array) $this->config('db', []));
        }

        return $this->db;
    }

    public function basePath(string $path = ''): string
    {
        return $path === '' ? $this->basePath : $this->basePath . '/' . ltrim($path, '/');
    }
}