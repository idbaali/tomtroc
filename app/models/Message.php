<?php

namespace App\Models;

use App\Models\User;

class Message
{
    private ?int $id = null;
    private ?User $sender = null;     // objet User plutôt que juste ID
    private ?User $receiver = null;   // objet User
    private string $content;
    private ?string $created_at = null;

    /**
     * Hydratation automatique depuis un tableau
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->content = trim($data['content'] ?? '');
            $this->created_at = $data['created_at'] ?? null;

            // Optionnel : si tu passes des objets User déjà instanciés
            $this->sender = $data['sender'] ?? null;
            $this->receiver = $data['receiver'] ?? null;
        }
    }

    // GETTERS
    public function getId(): ?int { return $this->id; }
    public function getSender(): ?User { return $this->sender; }
    public function getReceiver(): ?User { return $this->receiver; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // SETTERS (fluent)
    public function setSender(User $sender): self { $this->sender = $sender; return $this; }
    public function setReceiver(User $receiver): self { $this->receiver = $receiver; return $this; }
    public function setContent(string $content): self { $this->content = trim($content); return $this; }
}