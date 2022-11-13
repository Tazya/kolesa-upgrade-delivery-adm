<?php
namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class MessageController
{
    public function index(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'message/index.twig');
    }

    public function getMessage(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $messageText  = $request->getParsedBodyParam('messageText');
        return $view->render($response, 'message/index.twig', ["message" => $messageText]);
    }
}