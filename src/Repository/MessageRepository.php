<?php

namespace App\Repository;

use App\Model\Entity\Message;
use App\Repository\DB\DB;
use Yosymfony\Toml\Toml;
use PDO;

class MessageRepository 
{
    private const CONFIG_PATH = '../config/config.toml';

    public function create(array $advertData): Message 
    {
        $this->saveDB($advertData);

        return new Message($advertData);
    }

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $messageData) {
            $result[] = new Message($messageData);
        }

        return $result;
    }

    private function getDB() 
    {
        $cfg = Toml::ParseFile(self::CONFIG_PATH);
        $db = new DB($cfg);
        $connection = $db->connectDB();

        $messages = $connection->query('SELECT * FROM messages')->fetchAll(PDO::FETCH_ASSOC);

        return $messages ?? [];
    }

    private function saveDB($data) 
    {
        $cfg = Toml::ParseFile(self::CONFIG_PATH);
        $db = new DB($cfg);
        $connection = $db->connectDB();

        $statement = $connection->prepare('INSERT INTO messages(title, body, created_at) VALUES (:title, :body, :created_at)');
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('body', $data['body']);
        $now = date_create()->format('Y-m-d H:i:s');
        $statement->bindParam('created_at', $now);
        $statement->execute();
    }
}