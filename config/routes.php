<?php

use Amidope\PageAnalyzer\Db;
//use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;

/** @var \Slim\App<\Psr\Container\ContainerInterface> $app */
$app->get('/', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'index.twig');
})->setName('home');


$app->get('/urls', function (Request $request, Response $response) {
    /** @var Db $db */
    $db = $this->get('db');
    $urls = $db->getAllUrlsWithChek();
    return $this->get('view')->render($response, 'urls/index.twig', [
        'urls' => $urls
    ]);
})->setName('urls.index');

$app->post('/urls', function (Request $request, Response $response) {
    /** @var array $parsedBody */
    $parsedBody = $request->getParsedBody();
    $url = $parsedBody['url'] ?? null;

//    $url = $request->getParsedBodyParam('url');
    try {
        $this->get('validator')->validateUrl($url['name']);
    } catch (\Exception $e) {
        // TODO 422
        return $this->get('view')->render($response, 'index.twig', [
            'formValidationClass' => 'is-invalid'
        ])->withStatus(422);
    }
    $parsed = parse_url($url['name']);
    $normalizedUrl = $parsed['scheme'] . '://' . $parsed['host'];

    /** @var Db $db */
    $db = $this->get('db');
    $id = $db->getUrlIdByName($normalizedUrl);
    if (is_int($id)) {
        $this->get('flash')->addMessage('success', 'Страница уже существует ');
    } else {
        $db->saveUrl($normalizedUrl);
        $id = $db->getUrlIdByName($normalizedUrl);
        $this->get('flash')->addMessage('success', 'Страница успешно добавлена ');
    }
    $url = $this->get('router')->urlFor('urls.show', ['id' => $id]);
    return $response->withRedirect($url);

})->setName('urls.create');

$app->get('/urls/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $flash = $this->get('flash')->getMessages();
    $db = $this->get('db');
    $url = $db->getUrl($id);
    $checks = $db->getAllUrlChecks($id);

    return $this->get('view')->render($response, 'urls/show.twig', [
        'flash' => $flash,
        'url' => $url,
        'id' => $id,
        'checks' => $checks
    ]);
})->setName('urls.show');

$app->post('/urls/{id}/checks', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $db = $this->get('db');
    try {
        $db->saveUrlCheck($id);
    } catch (\Exception $exception) {
        $this->get('flash')->addMessage('danger', ' Произошла ошибка при проверке, не удалось подключиться');
    }
    if (empty($exception)) {
        $this->get('flash')->addMessage('success', 'Страница успешно проверена');
    }
    $url = $this->get('router')->urlFor('urls.show', ['id' => $id]);
    return $response->withRedirect($url);
})->setName('checks.create');


