<?php
namespace App\Http\Controllers;

use App\Model\Validators\MessageValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;
use GuzzleHttp\Client;
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
        
        if(!empty($errors)){
            return $view->render($response, 'message/index.twig', [
                "message" => $messageData,
                "errors" => $errors,
            ]);
        }
        $serviceClient = $this->container->get('serviceClient');
        $serviceResult = $serviceClient->request('POST', '/test', ['json' => $messageData]);
        $body = $serviceResult->getBody();
        $resultArray = json_decode($body, true);

        if(!array_key_exists("status", $resultArray)){
            return $response->write("Wrong data format");
        }

        if($resultArray["status"]==="error"){
            return $response->write("Error: " . $resultArray["error"]);
        }

        return $response->withHeader('Content-Type', 'application/json')->write($body);
    }

    public function test(ServerRequest $request, Response $response)
    {
        return $response->withHeader('Content-Type', 'application/json')->write('{"status":"error", "error":"aaaa"}');
    }

}