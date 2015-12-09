<?php
require '../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;

$app = new Slim\App();

$container = $app->getContainer();
$container['settings']['displayErrorDetails'] = true;

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => /*false*/ '../cache'
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app->add(function (Request $request,  Response $response, $next) {
    if ($request->getUri()->getScheme() !== 'https') {
        $uri = $request->getUri()->withScheme("https")->withPort(null);
        return $response->withRedirect( (string)$uri );
    } else {
        return $next($request, $response);
    }
});

$app->get('/', function (Request $request, Response $response, $args) {
    return $this->view->render($response, "index.twig", ["title" => "Welcome!"]);
});

$app->get('/articles/slim-intro[.html]', function (Request $request,  Response $response, $args) {
    return $this->view->render($response, "slim-intro.twig", ["title" => "Slim Introduction"]);
});

$app->get('/articles/php-app-architecture[.html]', function (Request $request,  Response $response, $args) {
    return $this->view->render($response, "php-app-architecture.twig", ["title" => "PHP App Architecture"]);
});

$app->run();
