<?php

use Psr\Http\Message\ServerRequestInterface as Request;
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
        /** @var \Slim\App<\Psr\Container\ContainerInterface> $app */
        $app = AppFactory::create();
        $app->add(TwigMiddleware::createFromContainer($app));
//        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
//        $errorMiddleware->setDefaultErrorHandler(function (
//            Request $request,
//            Throwable $exception,
//            bool $displayErrorDetails,
//            bool $logErrors,
//            bool $logErrorDetails
//        ) use ($app) {
//            // Логирование ошибки
//            error_log($exception->getMessage());
//
//            // Использование Twig для рендеринга страницы ошибки
//            $response = $app->getResponseFactory()->createResponse();
//            /** @var Twig $view */
//            $view = $app->getContainer()->get('view');
//            return $view->render($response, 'error.twig', [
//                'message' => 'Что-то пошло не так ¯\_(ツ)_/¯ Пожалуйста, попробуйте позже.',
//            ])->withStatus(500);
//        });

        return $app;
    },
    'db' => function () {
        return new Db();
    },
    'view' => function () {
        return Twig::create(
            '../templates'
//            [
//                'debug' => false,
//                'auto_reload' => true
//            ]
        );
    },
    'validator' => function () {
        return new Validator();
    },
    'router' => function (ContainerInterface $c) {
        /** @var \Slim\App<\Psr\Container\ContainerInterface> $app */
        $app = $c->get('app');
        $routeCollector = $app->getRouteCollector();
        return $routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs())->getRouteParser();
    },
    'flash' => function () {
        return new \Slim\Flash\Messages();
    }
];