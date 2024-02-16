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
$container->set('validator', function () {
    return new \App\Validator();
});
$container->set('view', function () {
    return Twig::create(
        '../templates',
        //TODO delete cache
        [
            'debug' => true,
            'cache' => '/home/u/projects/php-project-9/var/cache/twig',
            'auto_reload' => true
        ]
    );
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));

$routeCollector = $app->getRouteCollector();
$router = $routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs())->getRouteParser();

$app->get('/', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'index.twig');
})->setName('home');

$app->get('/urls', function (Request $request, Response $response) {
    $urlDb = new \App\Urldb();
    $urls = $urlDb->getAllUrlsWithChek();
    return $this->get('view')->render($response, 'urls/index.twig', [
        'urls' => $urls
    ]);
})->setName('urls.index');

$app->post('/urls', function (Request $request, Response $response) use ($router) {
    $url = $request->getParsedBodyParam('url');
    try {
        $this->get('validator')->validateUrl($url['name']);
    } catch (\Exception $e) {
        return $this->get('view')->render($response, 'index.twig', [
            'invalidDataFormMessage' => $e->getMessage()
        ]);
    }
    $parsed = parse_url($url['name']);
    $normalizedUrl = $parsed['scheme'] . '://' . $parsed['host'];

    $urlDb = new \App\Urldb();
    $id = $urlDb->getUrlIdByName($normalizedUrl);
    if (is_int($id)) {
        $this->get('flash')->addMessage('success', 'Страница уже существует ');
    } else {
        $urlDb->saveUrl($normalizedUrl);
        $id = $urlDb->getUrlIdByName($normalizedUrl);
        $this->get('flash')->addMessage('success', 'Страница успешно добавлена ');
    }
    $url = $router->urlFor('urls.show', ['id' => $id]);
    return $response->withRedirect($url, 302);

})->setName('urls.create');

$app->get('/urls/{id}', function (Request $request, Response $response, $id) {
    $flash = $this->get('flash')->getMessages();
    $urlDb = new \App\Urldb();
    $url = $urlDb->getUrl($id);
    $checks = $urlDb->getAllUrlChecks($id);

    return $this->get('view')->render($response, 'urls/show.twig', [
        'flash' => $flash,
        'url' => $url,
        'id' => $id,
        'checks' => $checks
    ]);
})->setName('urls.show');

$app->post('/urls/{id}/checks', function (Request $request, Response $response, $id) use ($router) {
    $urlDb = new \App\Urldb;
    try {
        $urlDb->saveUrlCheck($id);
    } catch (\Exception $e) {
        $exception = $e;
        // FIXME
//        dd($e->getMessage());
        $this->get('flash')->addMessage('error', ' Произошла ошибка при проверке, не удалось подключиться');
    }
    if (empty($exception)) {
        $this->get('flash')->addMessage('success', 'Страница успешно проверена');
    }
    $url = $router->urlFor('urls.show', ['id' => $id]);
    return $response->withRedirect($url, 302);
})->setName('checks.create');

$app->run();

