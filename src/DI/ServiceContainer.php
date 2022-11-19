<?php

namespace App\DI;

use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;


class ServiceContainer implements ContainerInterface
{
    private array $objects = [];

    public function get(string $id)
    {
        return $this->objects[$id]();
    }

    public function set(string $id, callable $fn)
    {
        $this->objects[$id] = $fn;
    }

    public function has(string $id)
    {
        return isset($this->objects[$id]);
    }

    public function registerServices()
    {
        $this->set('botService',  function () {
            $botService = new Client([
                'base_uri' => API_URI,
                'timeout' => 2.0,
            ]);
            return $botService;
        });
    }
}
