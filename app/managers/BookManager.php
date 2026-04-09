<?php

namespace App\Managers;

use App\Models\Book;
use App\Models\User;
use Core\BaseManager;

class BookManager extends BaseManager
{
    /**
     * Tous les livres
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
        ");

        return $this->createBookList($stmt);
    }

    /**
     * Livres d’un utilisateur
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

        return $this->createBookList($stmt);
    }

    /**
     * Livre par ID
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

        if (!$data) {
            return null;
        }

        return $this->createBook($data);
    }

    /**
     * Livre par slug
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

        if (!$data) {
            return null;
        }

        return $this->createBook($data);
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
            image = :image,
            status = :status
        WHERE id = :id
    ");

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'status' => $book->getStatus(),
            'id' => $book->getId()
        ]);
    }

    /**
     * Supprimer
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM books WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Derniers livres
     */
    public function getLatest(int $limit = 4): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.id AS owner_id, u.username AS owner_name, u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $this->createBookList($stmt);
    }

    /**
     * Créer une liste de livres
     */
    private function createBookList(\PDOStatement $stmt): array
    {
        $books = [];

        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $books[] = $this->createBook($data);
        }

        return $books;
    }

    /**
     * Créer un objet Book
     */
    private function createBook(array $data): Book
    {
        $owner = new User([
            'id' => $data['owner_id'],
            'username' => $data['owner_name'],
            'avatar' => $data['owner_avatar'] ?? 'default-user.png'
        ]);

        return new Book([
            'id' => $data['id'],
            'title' => $data['title'],
            'author' => $data['author'],
            'description' => $data['description'],
            'image' => $data['image'],
            'slug' => $data['slug'] ?? '',
            'status' => $data['status'] ?? null,
            'created_at' => $data['created_at'],
            'owner' => $owner
        ]);
    }
}
