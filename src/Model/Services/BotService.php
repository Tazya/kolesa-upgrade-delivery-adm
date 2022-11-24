<?php

namespace App\Model\Services;

use GuzzleHttp\ClientInterface;

class BotService
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendToAll(string $title, string $body)
    {
        $messageData = [
            "title" => $title,
            "body" => $body
        ];

        return $this->client->request('POST', '/messages/sendToAll', ['json' => $messageData]);
    }

    public function checkHealth()
    {
        return $this->client->request('GET', '/health');
    }
}
