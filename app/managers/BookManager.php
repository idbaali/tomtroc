<?php

namespace App\Managers;

use App\Models\Book;
use App\Models\User;
use Core\BaseManager;

class BookManager extends BaseManager
{
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT 
                b.*,
                u.id AS owner_id,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
        ");

        return $this->createBookList($stmt);
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                u.id AS owner_id,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.owner_id = :userId
            ORDER BY b.created_at DESC
        ");

        $stmt->execute([
            'userId' => $userId
        ]);

        return $this->createBookList($stmt);
    }

    public function getBySlug(string $slug): ?Book
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                u.id AS owner_id,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            WHERE b.slug = :slug
            LIMIT 1
        ");

        $stmt->execute([
            'slug' => $slug
        ]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->createBook($data);
    }

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

    public function update(Book $book): bool
    {
        $stmt = $this->db->prepare("
            UPDATE books
            SET title = :title,
                author = :author,
                description = :description,
                image = :image,
                status = :status,
                slug = :slug
            WHERE slug = :original_slug
        ");

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'status' => $book->getStatus(),
            'slug' => $book->getSlug(),
            'original_slug' => $book->getOriginalSlug()
        ]);
    }

    public function deleteBySlug(string $slug): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM books
            WHERE slug = :slug
        ");

        return $stmt->execute([
            'slug' => $slug
        ]);
    }

    public function getLatest(int $limit = 4): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.*,
                u.id AS owner_id,
                u.username AS owner_name,
                u.avatar AS owner_avatar
            FROM books b
            JOIN users u ON u.id = b.owner_id
            ORDER BY b.created_at DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $this->createBookList($stmt);
    }

    private function createBookList(\PDOStatement $stmt): array
    {
        $books = [];

        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $books[] = $this->createBook($data);
        }

        return $books;
    }

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
            'original_slug' => $data['slug'] ?? '',
            'status' => $data['status'] ?? null,
            'created_at' => $data['created_at'],
            'owner' => $owner
        ]);
    }
}