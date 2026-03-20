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

    public function getUserWithBooks(int $id): ?array
    {
        $stmt = $this->db->prepare("
        SELECT 
            u.id AS user_id,
            u.username,
            u.email,
            u.avatar,
            u.created_at,

            b.id AS book_id,
            b.title,
            b.author,
            b.description,
            b.image,
            b.status

        FROM users u
        LEFT JOIN books b ON b.owner_id = u.id
        WHERE u.id = :id
    ");

        $stmt->execute(['id' => $id]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        // 🔹 Utilisateur (1 seule fois)
        $user = [
            'id' => $rows[0]['user_id'],
            'username' => $rows[0]['username'],
            'email' => $rows[0]['email'],
            'avatar' => $rows[0]['avatar'],
            'created_at' => $rows[0]['created_at'],
        ];

        // 🔹 Livres
        $books = [];
        foreach ($rows as $row) {
            if (!empty($row['book_id'])) {
                $books[] = [
                    'id' => $row['book_id'],
                    'title' => $row['title'],
                    'author' => $row['author'],
                    'description' => $row['description'],
                    'image' => $row['image'],
                    'status' => $row['status'],
                ];
            }
        }

        return [
            'user' => $user,
            'books' => $books
        ];
    }
}
