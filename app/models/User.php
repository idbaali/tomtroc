<?php

namespace App\Models;

/**
 * Modèle User
 * -----------------
 * Représente un utilisateur de l'application.
 *
 * ⚠️ Ce modèle ne contient AUCUNE logique SQL.
 * Toutes les interactions avec la base sont gérées
 * par le UserManager.
 */
class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password; // mot de passe hashé
    private ?string $avatar;
    private string $created_at;

    /**
     * Hydratation automatique du modèle
     * Permet de remplir l'objet avec un tableau (ex: résultat PDO)
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->username = $data['username'] ?? '';
            $this->email = strtolower(trim($data['email'] ?? ''));
            $this->password = $data['password'] ?? '';
            $this->avatar = $data['avatar'] ?? null;
            $this->created_at = $data['created_at'] ?? '';
        }
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

    /**
     * ⚠️ Ne jamais exposer ce getter dans une API !
     */
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
        // Normalisation pour éviter les doublons
        $this->email = strtolower(trim($email));
    }

    public function setPassword(string $password): void
    {
        // On suppose que le password est déjà hashé
        $this->password = $password;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
