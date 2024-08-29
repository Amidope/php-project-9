<?php

namespace Amidope\PageAnalyzer;

use Slim\App;

function registerRoutes(App $app): void
{
    require __DIR__ . '/../config/routes.php';
}
function buildApp(): App
{
    $builder = new \DI\ContainerBuilder();
    $builder->addDefinitions(__DIR__ . '/../config/dependencies.php');
    $container = $builder->build();
    /** @var \Slim\App<\Psr\Container\ContainerInterface> $app */
    $app = $container->get('app');
    registerRoutes($app);
    return $app;
}
//
