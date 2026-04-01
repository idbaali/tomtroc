<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\User;
use App\Models\Book;

class UserManager extends BaseManager
{
    /**
     * Trouver un utilisateur par email
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

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->createUser($data);
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

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->createUser($data);
    }

    /**
     * Une seule requête → utilisateur + livres
     */
    public function getUserWithBooks(int $id): ?User
    {
        $stmt = $this->db->prepare("
            SELECT 
                u.id AS user_id,
                u.username,
                u.email,
                u.avatar,
                u.password,
                u.created_at AS user_created_at,
                b.id AS book_id,
                b.title,
                b.author,
                b.description,
                b.image,
                b.slug,
                b.status,
                b.created_at AS book_created_at
            FROM users u
            LEFT JOIN books b ON b.owner_id = u.id
            WHERE u.id = :id
            ORDER BY b.created_at DESC
        ");

        $stmt->execute(['id' => $id]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        // Création de l'utilisateur
        $user = new User([
            'id' => $rows[0]['user_id'],
            'username' => $rows[0]['username'],
            'email' => $rows[0]['email'],
            'avatar' => $rows[0]['avatar'],
            'password' => $rows[0]['password'],
            'created_at' => $rows[0]['user_created_at']
        ]);

        $books = [];

        // Création des livres
        foreach ($rows as $row) {

            if (empty($row['book_id'])) {
                continue;
            }

            $books[] = new Book([
                'id' => $row['book_id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'description' => $row['description'],
                'image' => $row['image'],
                'slug' => $row['slug'] ?? '',
                'status' => $row['status'],
                'created_at' => $row['book_created_at'],
                'owner' => $user
            ]);
        }

        $user->setBooks($books);

        return $user;
    }

    /**
     * Créer un objet User
     */
    private function createUser(array $data): User
    {
        return new User([
            'id' => $data['id'] ?? null,
            'username' => $data['username'] ?? '',
            'email' => $data['email'] ?? '',
            'avatar' => $data['avatar'] ?? 'default-user.png',
            'password' => $data['password'] ?? '',
            'created_at' => $data['created_at'] ?? ''
        ]);
    }
}