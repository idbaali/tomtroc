<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\User;

class UserManager extends BaseManager
{
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("
        SELECT id, username, email, avatar, password, created_at
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

        $stmt->execute(['email' => $email]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data);
    }

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

    public function getById(int $id): ?User
    {
        $stmt = $this->db->prepare("
        SELECT id, username, email, avatar, password, created_at
        FROM users
        WHERE id = :id
        LIMIT 1
    ");

        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data);
    }
}
