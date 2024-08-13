<?php /** @noinspection PhpParamsInspection */

use function Amidope\PageAnalyzer\buildApp;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$app = buildApp();

$app->run();
