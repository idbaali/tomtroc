<?php

namespace App\Models;

class User
{
    private int $id = 0;
    private string $username = '';
    private string $email = '';
    private string $password = '';
    private ?string $avatar = null;
    private string $created_at = '';

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->username = $data['username'] ?? '';
        $this->email = strtolower(trim($data['email'] ?? ''));
        $this->password = $data['password'] ?? '';
        $this->avatar = $data['avatar'] ?? null;
        $this->created_at = $data['created_at'] ?? '';
    }

    // ================= GETTERS =================

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    // ================= SETTERS =================

    public function setUsername(string $username): void
    {
        $this->username = trim($username);
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}