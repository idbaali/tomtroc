<?php

namespace App\Managers;

use App\Models\Book;
use Core\BaseManager;

/**
 * Manager des livres
 * -------------------
 * Gère toutes les opérations liées aux livres.
 * Hérite de BaseManager pour utiliser la connexion DB centralisée.
 */
class BookManager extends BaseManager
{
    /**
     * Récupère tous les livres
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT b.*, u.username AS seller
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
        ");

        return $stmt->fetchAll();
    }

    /**
     * Récupère les derniers livres
     */
    public function getLatest(int $limit = 4): array
    {
        // Sécurisation du LIMIT sans PDO::PARAM_INT
        $limit = (int) $limit;

        $stmt = $this->db->prepare("
            SELECT 
                b.id,
                b.title,
                b.author,
                b.image,
                b.slug,
                u.username AS seller
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
            LIMIT $limit
        ");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Récupère un livre via son slug
     */
    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.slug = :slug
            LIMIT 1
        ");

        $stmt->execute(['slug' => $slug]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Récupère un livre par son ID
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Livres d’un utilisateur
     */
    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.username AS seller
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.owner_id = :userId
            ORDER BY b.created_at DESC
        ");

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * Créer un livre
     */
    public function create(Book $book): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO books (title, author, description, image, owner_id, slug)
            VALUES (:title, :author, :description, :image, :owner_id, :slug)
        ");

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'owner_id' => $book->getOwnerId(),
            'slug' => $book->getSlug()
        ]);
    }

    /**
     * Mettre à jour un livre
     */
    public function update(Book $book): bool
    {
        $stmt = $this->db->prepare("
            UPDATE books
            SET title = :title,
                author = :author,
                description = :description,
                image = :image
            WHERE id = :id
        ");

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'id' => $book->getId()
        ]);
    }

    /**
     * Supprimer un livre
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM books
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }
}

