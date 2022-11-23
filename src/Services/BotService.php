<?php

namespace App\Services;

use GuzzleHttp\ClientInterface;
use Yosymfony\Toml\Toml;

class BotService
{
    private const CONFIG_PATH = '../config/config.toml';
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendToAll(string $title, string $body)
    {
        $cfg = Toml::ParseFile(self::CONFIG_PATH);

        $messageData = [
            "title" => $title,
            "body" => $body
        ];

        return $this->client->request('POST', $cfg['bot_service_addr'] . '/messages/sendToAll', ['json' => $messageData]);
    }
}
