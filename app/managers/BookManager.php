<?php

namespace App\Managers;

use App\Models\Book;
use App\Models\User;
use Core\BaseManager;

class BookManager extends BaseManager
{
    /**
     * Récupère tous les livres avec leur propriétaire
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
        ");

        $books = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data['owner'] = new User([
                'id' => $data['owner_id'] ?? null,
                'username' => $data['owner_name'] ?? null,
                'avatar' => $data['owner_avatar'] ?? null
            ]);
            $books[] = new Book($data);
        }

        return $books;
    }

    /**
     * Récupère les livres d’un utilisateur
     */
    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
        SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
        FROM books b
        JOIN users u ON u.id = b.owner_id
        WHERE b.owner_id = :userId
        ORDER BY b.created_at DESC
    ");
        $stmt->execute(['userId' => $userId]);

        $books = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            // Crée l'objet User pour le propriétaire
            $owner = new \App\Models\User([
                'id' => $data['owner_id'] ?? 0,
                'username' => $data['owner_name'] ?? '',
                'avatar' => $data['owner_avatar'] ?? null
            ]);

            // Crée l'objet Book avec l'owner
            $book = new \App\Models\Book([
                'id' => $data['id'],
                'title' => $data['title'],
                'author' => $data['author'],
                'description' => $data['description'] ?? null,
                'image' => $data['image'] ?? null,
                'owner' => $owner,
                'slug' => $data['slug'] ?? '',
                'created_at' => $data['created_at'] ?? '',
                'status' => $data['status'] ?? null
            ]);

            $books[] = $book;
        }

        return $books;
    }

    /**
     * Récupère un livre via son ID
     */
    public function getById(int $id): ?Book
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) return null;

        $data['owner'] = new User([
            'id' => $data['owner_id'] ?? null,
            'username' => $data['owner_name'] ?? null,
            'avatar' => $data['owner_avatar'] ?? null
        ]);

        return new Book($data);
    }

    /**
     * Récupère un livre via son slug
     */
    public function getBySlug(string $slug): ?Book
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.slug = :slug
            LIMIT 1
        ");

        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) return null;

        $data['owner'] = new User([
            'id' => $data['owner_id'] ?? null,
            'username' => $data['owner_name'] ?? null,
            'avatar' => $data['owner_avatar'] ?? null
        ]);

        return new Book($data);
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
            'owner_id' => $book->getOwner()->getId(),
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

    /**
     * Récupère les derniers livres
     */
    public function getLatest(int $limit = 4): array
    {
        $limit = (int) $limit; // sécurité

        $stmt = $this->db->prepare("
        SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
        FROM books b
        JOIN users u ON u.id = b.owner_id
        ORDER BY b.created_at DESC
        LIMIT :limit
    ");

        // Pour LIMIT avec PDO il faut bindParam en type INT
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $books = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data['owner'] = new \App\Models\User([
                'id' => $data['owner_id'] ?? null,
                'username' => $data['owner_name'] ?? null,
                'avatar' => $data['owner_avatar'] ?? null
            ]);

            $books[] = new \App\Models\Book($data);
        }

        return $books;
    }
}
