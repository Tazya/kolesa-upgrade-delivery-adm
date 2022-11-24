<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use App\DI\ServiceContainer;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

const API_URI = "localhost:8888";

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$container = new ServiceContainer();
$container->registerServices();
AppFactory::setContainer($container);
$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));
$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/health', Controllers\HealthController::class . ':index');
$app->post('/health', Controllers\HealthController::class . ':index');
$app->get('/messages', Controllers\MessageController::class . ':allMessages');
$app->get('/message/new', Controllers\MessageController::class . ':index');
$app->post('/message/send', Controllers\MessageController::class . ':sendMessage');
$app->run();
