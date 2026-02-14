<?php

namespace App\Models;

class Message
{
    private ?int $id = null;
    private int $sender_id;
    private int $receiver_id;
    private string $content;
    private ?string $created_at = null;

    /**
     * Hydratation automatique depuis un tableau
     * Exemple : new Message($_POST) ou résultat SQL
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {

            $this->id = $data['id'] ?? null;
            $this->sender_id = (int) ($data['sender_id'] ?? 0);
            $this->receiver_id = (int) ($data['receiver_id'] ?? 0);
            $this->content = trim($data['content'] ?? '');
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    // ✅ GETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    public function getReceiverId(): int
    {
        return $this->receiver_id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    // ✅ SETTERS (fluent = PRO 🔥)

    public function setSenderId(int $sender_id): self
    {
        $this->sender_id = $sender_id;
        return $this;
    }

    public function setReceiverId(int $receiver_id): self
    {
        $this->receiver_id = $receiver_id;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = trim($content);
        return $this;
    }
}
