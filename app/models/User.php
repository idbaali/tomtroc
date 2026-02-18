<?php

namespace App\Models;

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password; // hashé
    private ?string $avatar;
    private string $created_at;

    // ✅ Constructeur (hydratation automatique)
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->username = $data['username'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->password = $data['password'] ?? '';
            $this->avatar = $data['avatar'] ?? null;
            $this->created_at = $data['created_at'] ?? '';
        }
    }

    // ✅ GETTERS
    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getAvatar(): ?string { return $this->avatar; }
    public function getCreatedAt(): string { return $this->created_at; }

    // ✅ SETTERS
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setAvatar(?string $avatar): void { $this->avatar = $avatar; }
}

?>






















<?php

// namespace App\Models;

/**
 * Modèle User
 * ------------
 * Représente un utilisateur.
 * Les opérations sur la base de données sont gérées par un UserManager.
 */
// class User
// {
    // Propriétés correspondant aux colonnes de la table users
//     public int $id;
//     public string $username;
//     public string $email;
//     public string $password; // hashé
//     public ?string $avatar;
//     public string $created_at;
// }
