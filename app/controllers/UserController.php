<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\User;

class UserManager extends BaseManager
{
    /**
     * Récupère un utilisateur par email
     */
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("
            SELECT id, username, email, avatar, password, created_at
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute(['email' => $email]);

        return $stmt->fetchObject(User::class) ?: null;
    }

    /**
     * Créer un utilisateur
     */
    public function create(string $username, string $email, string $passwordHash): bool
    {
        if ($this->findByEmail($email)) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password, created_at)
            VALUES (:username, :email, :password, NOW())
        ");

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash
        ]);
    }

    /**
     * Récupérer un utilisateur par ID
     */
    public function getById(int $id): ?User
    {
        $stmt = $this->db->prepare("
            SELECT id, username, email, avatar, password, created_at
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetchObject(User::class) ?: null;
    }
}