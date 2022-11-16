<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use DI\Container;
use GuzzleHttp\Client;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

const API_URI = "localhost:8080"; 

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$container = new Container();
AppFactory::setContainer($container);

$app  = AppFactory::create();
$container->set('serviceClient',  function($container) {
    $serviceClient = new Client([
        'base_uri' => API_URI,
        'timeout' => 2.0,
    ]);
    return $serviceClient;
    }
);

$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));
$app->get('/', Controllers\IndexController::class . ':home');
$app->post('/test', Controllers\MessageController::class . ':test');
$app->get('/message/new', Controllers\MessageController::class . ':index');
$app->post('/message/send', Controllers\MessageController::class . ':sendMessage');
$app->run();