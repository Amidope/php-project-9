<?php


namespace Amidope\PageAnalyzer;

use PDO;
use function ltrim;
use function parse_url;
use function sprintf;

class Connection
{
    private static ?Connection $conn = null;

    protected function createDsnFromUrl(string $databaseUrl): string
    {
        $databaseUrl = parse_url($_ENV['DATABASE_URL']);
        $databaseUrl['port'] = $databaseUrl['port'] ?? '5432';
        return sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $databaseUrl['host'],
            $databaseUrl['port'],
            ltrim($databaseUrl['path'], '/'),
            $databaseUrl['user'],
            $databaseUrl['pass']
        );
    }
    public function connect(): PDO
    {
        $dsn = $_ENV['DSN'] ?? $this->createDsnFromUrl($_ENV['DATABASE_URL']);
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
