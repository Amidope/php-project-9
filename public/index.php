<?php /** @noinspection PhpParamsInspection */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Handlers\Strategies\RequestResponseArgs;
use DI\Container;


require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();

$container->set('flash', function () {
    return new Slim\Flash\Messages();
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$twig = Twig::create( '../templates', ['debug' => true]);
$app->add(TwigMiddleware::create($app, $twig));

$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

$app->get('/', function (Request $request, Response $response) {
    $view = Twig::fromRequest($request);
    $pdo = \App\Connection::get()->connect();
    // TABLE USERS
    // таблица с проверками
    var_dump($pdo);
    return $view->render($response, 'index.twig', [
        'linkMainActive' => 'active'
    ]);
})->setName('home');

$app->get('/urls', function (Request $request, Response $response) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'urls/index.twig', [
        'linkUrlsActive' => 'active'
    ]);
})->setName('urls.index');

$app->get('/urls/{id}', function (Request $request, Response $response, $id) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'urls/show.twig', [
        'id' => $id
    ]);
})->setName('urls.show');

$app->run();
