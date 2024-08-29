<?php

namespace Amidope\PageAnalyzer;

use Slim\App;

/**
 * @param \Slim\App<\Psr\Container\ContainerInterface> $app
 * @return void
 */
function registerRoutes(App $app): void
{
    require __DIR__ . '/../config/routes.php';
}

/**
 * @return \Slim\App<\Psr\Container\ContainerInterface>
 */
function buildApp(): App
{
    $builder = new \DI\ContainerBuilder();
    $builder->addDefinitions(__DIR__ . '/../config/dependencies.php');
    $container = $builder->build();
    $app = $container->get('app');
    registerRoutes($app);
    return $app;
}
//
