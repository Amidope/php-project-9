<?php /** @noinspection PhpParamsInspection */

use function Amidope\PageAnalyzer\buildApp;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->safeLoad();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$app = buildApp();

$app->run();
