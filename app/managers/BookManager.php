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

        $booksData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $books = [];

        foreach ($booksData as $data) {
            $book = new Book($data);
            $book->setSeller($data['seller'] ?? null);
            $books[] = $book;
        }

        return $books;
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

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }

    /**
     * Récupère un livre via son slug
     */

    public function getBySlug(string $slug): ?Book
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

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        // Instancie Book et rempli les propriétés "join"
        $book = new Book($data);
        $book->setOwnerName($data['owner_name'] ?? null);
        $book->setOwnerAvatar($data['owner_avatar'] ?? null);

        return $book;
    }

    /**
     * Récupère un livre par son ID
     */
    public function getById(int $id): ?Book
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

        return $stmt->fetchObject(Book::class) ?: null;
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

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Book::class);
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

    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
        SELECT * FROM books
        WHERE owner_id = ?
        ORDER BY created_at DESC
    ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }
}
