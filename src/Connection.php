<?php

namespace Amidope\PageAnalyzer;

use PDO;

use function ltrim;
use function parse_url;
use function sprintf;

class Connection
{
    protected static ?Connection $conn = null;

    protected function createDsnFromUrl(string $databaseUrl): string
    {
        $parsedUrl = parse_url($databaseUrl);
        $host = $parsedUrl['host'] ?? '';
        $port = $parsedUrl['port'] ?? '5432';
        $dbname = ltrim($parsedUrl['path'] ?? '', '/');
        $user = $parsedUrl['user'] ?? '';
        $password = $parsedUrl['pass'] ?? '';
        return sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $host,
            $port,
            $dbname,
            $user,
            $password
        );
    }
    public function connect(): PDO
    {
        $dsn = $_ENV['DSN'] ?? $this->createDsnFromUrl($_ENV['DATABASE_URL']);
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function get(): Connection
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
