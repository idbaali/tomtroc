<?php

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private ?int $user_id = null;
    private ?string $description;
    private ?string $image;
    private int $owner_id;
    private string $slug;
    private string $created_at;
    private ?string $status = null; 
    private ?string $seller = null;
    private ?string $owner_name = null;
    private ?string $owner_avatar = null;

    // ✅ Constructeur
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->title = $data['title'] ?? '';
            $this->author = $data['author'] ?? '';
            $this->user_id = $data['user_id'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->image = $data['image'] ?? null;
            $this->owner_id = $data['owner_id'] ?? 0;
            $this->slug = $data['slug'] ?? '';
            $this->created_at = $data['created_at'] ?? '';
            $this->status = $data['status'] ?? null;
            $this->seller = $data['seller'] ?? null;
            $this->owner_name = $data['owner_name'] ?? null;
            $this->owner_avatar = $data['owner_avatar'] ?? null;
        }
    }

    // ✅ GETTERS
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getUserId(): ?int { return $this->user_id; }
    public function getDescription(): ?string { return $this->description; }
    public function getImage(): ?string { return $this->image; }
    public function getOwnerId(): int { return $this->owner_id; }
    public function getSlug(): string { return $this->slug; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getStatus(): ?string { return $this->status; }
    public function getSeller(): ?string { return $this->seller; }
    public function getOwnerName(): ?string { return $this->owner_name; }
    public function getOwnerAvatar(): ?string { return $this->owner_avatar; }

    // ✅ SETTERS
    public function setTitle(string $title): void { $this->title = $title; }
    public function setAuthor(string $author): void { $this->author = $author; }
    public function setUserId(?int $user_id): void { $this->user_id = $user_id; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setOwnerId(int $owner_id): void { $this->owner_id = $owner_id; }
    public function setSlug(string $slug): void { $this->slug = $slug; }
    public function setStatus(?string $status): void { $this->status = $status; }
    public function setSeller(?string $seller): void { $this->seller = $seller; }
    public function setOwnerName(?string $owner_name): void { $this->owner_name = $owner_name; }
    public function setOwnerAvatar(?string $owner_avatar): void { $this->owner_avatar = $owner_avatar; }    
}





















