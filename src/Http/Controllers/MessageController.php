<?php

namespace App\Http\Controllers;

use App\Model\Validators\MessageValidator;
use App\Repository\MessageRepository;
use App\Model\Services\BotService;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;

class MessageController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function index(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'message/index.twig');
    }

    public function sendMessage(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $messageData  = $request->getParsedBodyParam('message', []);
        $validator = new MessageValidator();
        $errors = $validator->validate($messageData);

        if (!empty($errors)) {
            return $view->render($response, 'message/index.twig', [
                "message" => $messageData,
                "errors" => $errors,
            ]);
        }

        $repo = new MessageRepository();
        $repo->create($messageData);

        $botClient = new BotService($this->container->get('botService'));
        $serviceResult = $botClient->sendToAll($messageData['title'], $messageData['body']);
        $body = (string)$serviceResult->getBody();
        $resultArray = json_decode($body, true);

        if (!array_key_exists("status", $resultArray)) {
            return $response->write("Wrong data format");
        }

        if ($resultArray["status"] === "error") {
            return $response->write("Error: " . $resultArray["error"]);
        }

        return $response->withJson(json_decode($body));
    }

    public function test(ServerRequest $request, Response $response)
    {
        return $response->withJson([
            "status" => "ok",
        ]);
    }
    
    public function allMessages(ServerRequest $request, Response $response) 
    {
        $repo = new MessageRepository();
        $messages = $repo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'message/messages.twig', ["messages" => $messages]);
    }
}
