<?php

namespace App\Http\Controllers;

use App\Model\Services\BotService;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;

class HealthController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function index(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $botClient = new BotService($this->container->get('botService'));
        $serviceResult = $botClient->checkHealth();
        $body = (string)$serviceResult->getBody();
        $resultArray = json_decode($body, true);

        if (!array_key_exists("status", $resultArray)) {
            return $response->write("Wrong data format");
        }

        return $view->render($response, 'health/index.twig', [
            'error' => $resultArray['error']
        ]);
    }
}
