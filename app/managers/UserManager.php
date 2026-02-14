<?php

namespace App\Managers;

use Core\BaseManager;

/**
 * UserManager
 * -----------------
 * Gère les interactions avec la table users.
 */
class UserManager extends BaseManager
{
    /**
     * Utilisateur par ID
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, username, email, avatar
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Trouver par email
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute(['email' => $email]);

        return $stmt->fetch() ?: null;
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
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ");

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash
        ]);
    }
}
