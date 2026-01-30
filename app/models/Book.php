<?php

namespace App\Models;

use PDO;
use Core\Database;

/**
 * Modèle Book
 * ------------
 * Gère toutes les opérations liées aux livres
 */
class Book
{
    private PDO $db;

    public function __construct()
    {
        // Connexion à la base de données via le singleton
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
     * Récupérer un livre par son slug
     */
    public function getBySlug(string $slug)
    {
        $sql = "
            SELECT 
                b.*,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON b.owner_id = u.id
            WHERE b.slug = :slug
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Récupère un livre par son ID
     *
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.username AS seller
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère les livres d’un utilisateur
     *
     * @param int $userId
     * @return array
     */
    public function getByOwner(int $ownerId): array
    {
        $sql = "SELECT * FROM books WHERE owner_id = :owner_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['owner_id' => $ownerId]);

        return $stmt->fetchAll();
    }


    /**
     * Récupère les derniers livres ajoutés
     *
     * @param int $limit
     * @return array
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

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    /**
     * Récupère les livres d’un utilisateur par user_id
     *
     * @param int $userId
     * @return array
     */
    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE owner_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau livre en base de données
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $sql = "INSERT INTO books (title, author, description, image, owner_id, slug)
            VALUES (:title, :author, :description, :image, :owner_id, :slug)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':description' => $data['description'],
            ':image' => $data['image'] ?? null,
            ':owner_id' => $data['owner_id'],
            ':slug' => $data['slug'],
        ]);
    }
}
