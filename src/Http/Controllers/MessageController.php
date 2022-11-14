<?php
namespace App\Http\Controllers;

use App\Model\Validators\MessageValidator;
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

    public function sendMessage(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $messageData  = $request->getParsedBodyParam('message', []);
        $validator = new MessageValidator();
        $errors = $validator->validate($messageData);
        
        if(!empty($errors)){
            return $view->render($response, 'message/index.twig', [
                "message" => $messageData,
                "errors" => $errors,
            ]);
        }
        return $view->render($response, 'message/index.twig', ["message" => $messageData]);
    }
}