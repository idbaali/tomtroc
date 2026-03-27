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

        // On retourne un objet User
        return new User($data);
    }

    /**
     * ➕ Créer un utilisateur
     */
    public function create(string $username, string $email, string $passwordHash): bool
    {
        // Vérifie si l'email existe déjà
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
     * Récupérer un utilisateur seul (sans livres)
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

        return new User($data);
    }

    /**
     * 🎯 OBJECTIF MENTOR :
     * UNE SEULE REQUÊTE avec jointure
     * → récupérer utilisateur + ses livres
     */
    public function getUserWithBooks(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                u.id AS user_id,
                u.username,
                u.email,
                u.avatar,
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

            -- Jointure pour récupérer les livres du user
            LEFT JOIN books b ON b.owner_id = u.id

            WHERE u.id = :id

            -- Important pour afficher les livres récents en premier
            ORDER BY b.created_at DESC
        ");

        $stmt->execute(['id' => $id]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Aucun utilisateur trouvé
        if (!$rows) {
            return null;
        }

        /**
         * Création des objets BOOK
         * Chaque livre reçoit le même owner (User)
         */
        $books = [];

        foreach ($rows as $row) {

            // Si pas de livre (LEFT JOIN)
            if (!empty($row['book_id'])) {

                $books[] = new Book([
                    'id' => $row['book_id'],
                    'title' => $row['title'],
                    'author' => $row['author'],
                    'description' => $row['description'],
                    'image' => $row['image'],
                    'slug' => $row['slug'] ?? '',
                    'status' => $row['status'],
                    'created_at' => $row['book_created_at'] ?? '',
                ]);
            }
        }


        /**
         * Création de l'objet USER (une seule fois)
         */
        $user = new User([
            'id' => $rows[0]['user_id'],
            'username' => $rows[0]['username'],
            'email' => $rows[0]['email'],
            'avatar' => $rows[0]['avatar'],
            'created_at' => $rows[0]['user_created_at'],
            'books' => $books
        ]);


        /**
         * On retourne :
         * - un objet User
         * - un tableau d'objets Book
         */
        return [
            'user' => $user,        ];
    }
}