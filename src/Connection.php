<?php

/** @noinspection PhpComposerExtensionStubsInspection */

namespace App;

use PDO;

class Connection
{
    private static ?Connection $conn = null;

    public function connect(): PDO
    {
//      "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s"

        $databaseUrl = parse_url($_ENV['DATABASE_URL']);
        $databaseUrl['port'] = $databaseUrl['port'] ?? '5432';
        $dsn = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $databaseUrl['host'],
            $databaseUrl['port'],
            ltrim($databaseUrl['path'], '/'),
            $databaseUrl['user'],
            $databaseUrl['pass']
        );
        //dd($dsn);
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function get(): ?Connection
    {
        if (static::$conn === null) {
            static::$conn = new self();
        }
        return static::$conn;
    }
    protected function __construct()
    {
    }
}
