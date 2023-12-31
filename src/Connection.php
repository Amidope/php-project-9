<?php

namespace App;

class Connection
{
    private static ?Connection $conn = null;

    public function connect()
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
        $pdo = new \PDO($dsn);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function get()
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