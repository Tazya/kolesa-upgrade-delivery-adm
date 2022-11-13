<?php

namespace App\Model\Entity;

class Message
{
    private ?int    $id;
    private ?string $title;
    private ?string $body;
    private ?int    $length;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->body = $data['body'] ?? null;
        $this->setLength();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getBody(): string
    {
        return $this->body ?? '';
    }

    public function getLength(): string
    {
        return $this->length ?? '';
    }

    public function setLength()
    {
        $this->length = strlen($this->getTitle() ?? '') + strlen($this->getBody);
    }


    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'length' => $this->getLength(),
        ];
    }
}
