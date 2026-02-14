<?php

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private ?string $description;
    private ?string $image;
    private int $owner_id;
    private string $slug;
    private string $created_at;

    // ✅ Constructeur
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->title = $data['title'] ?? '';
            $this->author = $data['author'] ?? '';
            $this->description = $data['description'] ?? null;
            $this->image = $data['image'] ?? null;
            $this->owner_id = $data['owner_id'] ?? 0;
            $this->slug = $data['slug'] ?? '';
            $this->created_at = $data['created_at'] ?? '';
        }
    }

    // ✅ GETTERS
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getDescription(): ?string { return $this->description; }
    public function getImage(): ?string { return $this->image; }
    public function getOwnerId(): int { return $this->owner_id; }
    public function getSlug(): string { return $this->slug; }
    public function getCreatedAt(): string { return $this->created_at; }

    // ✅ SETTERS
    public function setTitle(string $title): void { $this->title = $title; }
    public function setAuthor(string $author): void { $this->author = $author; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setOwnerId(int $owner_id): void { $this->owner_id = $owner_id; }
    public function setSlug(string $slug): void { $this->slug = $slug; }
}

?>



















