<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$twig = Twig::create( '../templates', ['debug' => true]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function (Request $request, Response $response, $args) use ($twig) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.twig', [
        'linkMainActive' => 'active'
    ]);
})->setName('root');



$app->run();
