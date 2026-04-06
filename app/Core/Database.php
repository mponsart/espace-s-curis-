<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    public static function connect(array $config): PDO
    {
        $driver = (string) ($config['driver'] ?? 'sqlite');

        if ($driver !== 'sqlite') {
            throw new \RuntimeException('Seul le driver SQLite est supporte par cette application.');
        }

        $projectRoot = dirname(__DIR__, 2);
        $path = (string) ($config['path'] ?? 'database/database.sqlite');
        $dbPath = str_starts_with($path, '/') ? $path : $projectRoot . '/' . ltrim($path, '/');

        $dbDirectory = dirname($dbPath);
        if (!is_dir($dbDirectory)) {
            mkdir($dbDirectory, 0755, true);
        }

        $isNewDatabase = !is_file($dbPath) || filesize($dbPath) === 0;

        $pdo = new PDO(
            'sqlite:' . $dbPath,
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        $pdo->exec('PRAGMA foreign_keys = ON;');

        if ($isNewDatabase) {
            $schemaFile = $projectRoot . '/database/schema.sql';
            if (!is_file($schemaFile)) {
                throw new \RuntimeException('Schema SQLite introuvable : database/schema.sql');
            }

            $schema = file_get_contents($schemaFile);
            if ($schema === false || trim($schema) === '') {
                throw new \RuntimeException('Le schema SQLite est vide ou illisible.');
            }

            $pdo->exec($schema);
        }

        return $pdo;
    }
}