<?php

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Amidope\PageAnalyzer\Db;
use Amidope\PageAnalyzer\Validator;

return [
    'app' => function (ContainerInterface $c) {
        AppFactory::setContainer($c);
        $app = AppFactory::create();
        $app->add(TwigMiddleware::createFromContainer($app));
        return $app;
    },
    'db' => function () {
        return new Db();
    },
    'view' => function () {
        return Twig::create(
            '../templates',
            //TODO delete cache
            [
                'debug' => true,
                'cache' => '/home/u/projects/php-project-9/var/cache/twig',
                'auto_reload' => true
            ]
        );
    },
    'validator' => function () {
        return new Validator();
    },
    'router' => function (ContainerInterface $c) {
        $app = $c->get('app');
        $routeCollector = $app->getRouteCollector();
        return $routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs())->getRouteParser();
    },
    'flash' => function () {
        return new \Slim\Flash\Messages();
    }
];