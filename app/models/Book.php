<?php

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private ?string $description;
    private ?string $image;
    private ?User $owner;
    private string $slug;
    private string $created_at;
    private ?string $status = null;
    private ?string $seller = null;

    // Constructeur
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->title = $data['title'] ?? '';
            $this->author = $data['author'] ?? '';
            $this->description = $data['description'] ?? null;
            $this->image = $data['image'] ?? null;
            $this->owner = $data['owner'] ?? null;
            $this->slug = $data['slug'] ?? '';
            $this->created_at = $data['created_at'] ?? '';
            $this->status = $data['status'] ?? null;
        }
    }

    // GETTERS
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getDescription(): ?string { return $this->description; }
    public function getImage(): ?string { return $this->image; }
    public function getOwner(): ?User { return $this->owner; }
    public function getOwnerId(): ?int { return $this->owner ? $this->owner->getId() : null; }
    public function getSlug(): string { return $this->slug; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getStatus(): ?string { return $this->status; }
    

    // SETTERS
    public function setTitle(string $title): void { $this->title = $title; }
    public function setAuthor(string $author): void { $this->author = $author; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setOwner(User $owner): void { $this->owner = $owner; }
    public function setSlug(string $slug): void { $this->slug = $slug; }
    public function setStatus(?string $status): void { $this->status = $status; }
}