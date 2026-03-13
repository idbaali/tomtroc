<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\BookManager;
use App\Models\Book;

/**
 * Contrôleur des livres
 * ----------------------
 * Liste, affiche et enregistre les livres.
 */
class BookController extends Controller
{
    private BookManager $bookManager;

    public function __construct()
    {
        parent::__construct();
        $this->bookManager = new BookManager();
    }

    /**
     * Liste tous les livres
     */
    public function index(): void
    {
        $books = $this->bookManager->getAll();

        // Vérification si aucun livre
        if (empty($books)) {
            echo "Aucun livre trouvé !";
            exit;
        }

        $this->render('books', [
            'title' => 'Nos livres à l’échange',
            'books' => $books
        ]);
    }

    /**
     * Affiche un livre par ID ou slug
     */
    public function show($param): void
    {
        if (!$param) {
            http_response_code(404);
            echo "Livre introuvable";
            return;
        }

        if (ctype_digit($param)) {
            $book = $this->bookManager->getById((int)$param);
        } else {
            $book = $this->bookManager->getBySlug($param);
        }

        if (!$book) {
            http_response_code(404);
            echo "Livre introuvable";
            return;
        }

        $this->render('book', [
            'title' => $book->getTitle(),
            'book'  => $book
        ]);
    }

    /**
     * Affiche le formulaire d'édition d'un livre
     */
    public function edit(?int $id): void
    {
        if (!$id) {
            http_response_code(404);
            $this->render('edit-book', ['book' => null]);
            return;
        }

        $book = $this->bookManager->getById($id);

        if (!$book) {
            http_response_code(404);
            echo "Livre introuvable";
            return;
        }

        $this->render('edit-book', ['book' => $book]);
    }

    /**
     * Enregistre un nouveau livre
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        // Récupère les données du formulaire
        $data = $_POST;

        // Génère un slug
        $data['slug'] = $this->generateSlug($data['title']);

        // Crée un nouvel objet Book
        $book = new Book([
            'title' => $data['title'],
            'author' => $data['author'],
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? '',
            'owner_id' => $data['owner_id'] ?? 1, // Valeur par défaut si nécessaire
            'slug' => $data['slug']
        ]);

        $this->bookManager->create($book);

        // Redirection vers la liste des livres
        header('Location: /livres');
        exit;
    }

    /**
     * Génère un slug à partir d'un titre
     */
    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
