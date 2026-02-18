<?php

namespace App\Managers;

use PDO;
use Core\Database;

class BookManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les derniers livres ajoutés
     */
    public function getLatest(int $limit = 4): array
    {
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
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un livre par son slug
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
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Crée un nouveau livre
     */
    public function create(array $data): void
    {
        $sql = "INSERT INTO books (title, author, description, image, owner_id, slug)
                VALUES (:title, :author, :description, :image, :owner_id, :slug)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':description' => $data['description'] ?? null,
            ':image' => $data['image'] ?? null,
            ':owner_id' => $data['owner_id'],
            ':slug' => $data['slug'],
        ]);
    }

    /**
     * Récupère tous les livres d'un utilisateur
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
        $stmt->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
