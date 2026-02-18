<?php

namespace App\Models;

class Message
{
    private int $id;
    private int $sender_id;
    private int $receiver_id;
    private string $content;
    private string $created_at;

    // ✅ CONSTRUCTEUR → ICI
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->sender_id = $data['sender_id'] ?? 0;
            $this->receiver_id = $data['receiver_id'] ?? 0;
            $this->content = $data['content'] ?? '';
            $this->created_at = $data['created_at'] ?? '';
        }
    }

    // GETTERS
    public function getId(): int { return $this->id; }
    public function getSenderId(): int { return $this->sender_id; }
    public function getReceiverId(): int { return $this->receiver_id; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): string { return $this->created_at; }

    // SETTERS
    public function setSenderId(int $sender_id): void { $this->sender_id = $sender_id; }
    public function setReceiverId(int $receiver_id): void { $this->receiver_id = $receiver_id; }
    public function setContent(string $content): void { $this->content = $content; }
}
