<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\BookManager;

/**
 * Contrôleur des livres
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
            'title' => $book['title'],
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

        $data = $_POST;
        $data['slug'] = generateSlug($data['title']);
        $this->bookManager->create($data);

        header('Location: /livres');
        exit;
    }

}
