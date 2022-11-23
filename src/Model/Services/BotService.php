<?php

namespace App\Model\Services;

use GuzzleHttp\ClientInterface;

class BotService
{
    const ADDR = 'localhost:8888';
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

        return $this->client->request('POST', self::ADDR . '/messages/sendToAll', ['json' => $messageData]);
    }
}
