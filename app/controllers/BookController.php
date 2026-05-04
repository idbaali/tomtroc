<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\BookManager;
use App\Models\Book;
use App\Services\Validations;
use App\Services\Authorizations;
use App\Services\FileUploader;
use App\Services\Slugger;

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
     * Affiche un livre uniquement par slug
     */
    public function show(?string $slug): void
    {
        if (!$slug) {
            http_response_code(404);
            echo 'Livre introuvable';
            return;
        }

        $book = $this->bookManager->getBySlug($slug);

        if (!$book) {
            http_response_code(404);
            echo 'Livre introuvable';
            return;
        }

        $this->render('book', [
            'title' => $book->getTitle(),
            'book' => $book
        ]);
    }

    /**
     * Formulaire de création d'un livre
     */
    public function form(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $this->render('create-book', [
            'title' => 'Créer un nouveau livre',
            'user' => $user
        ]);
    }

    /**
     * Création d'un livre
     */
    public function create(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $_SESSION['old_create_book'] = [
            'title' => $title,
            'author' => $author,
            'description' => $description
        ];

        $errors = Validations::validateBookCreation($_POST, $_FILES);

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/creation-livre');
            return;
        }

        $imageName = 'default.png';

        if (
            isset($_FILES['image']) &&
            ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE
        ) {
            $uploadedImage = FileUploader::uploadBookImage($_FILES['image']);

            if ($uploadedImage === null) {
                setFlash('error', 'Impossible d’enregistrer l’image.');
                redirect('/creation-livre');
                return;
            }

            $imageName = $uploadedImage;
        }

        $book = new Book([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'image' => $imageName,
            'owner' => $user,
            'slug' => Slugger::generate($title)
        ]);

        if (!$this->bookManager->create($book)) {
            setFlash('error', 'Erreur lors de l’ajout du livre.');
            redirect('/creation-livre');
            return;
        }

        unset($_SESSION['old_create_book']);

        setFlash('success', 'Livre ajouté avec succès.');
        redirect('/compte');
    }

    /**
     * Formulaire d'édition + traitement de modification
     */
    public function edit(?string $slug): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        if (!$slug) {
            http_response_code(404);
            echo 'Livre introuvable';
            return;
        }

        $book = $this->bookManager->getBySlug($slug);

        if (!Authorizations::canManageBook($user, $book)) {
            setFlash('error', 'Action non autorisée.');
            redirect('/compte');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = trim($_POST['status'] ?? 'available');

            $errors = Validations::validateBookCreation($_POST, $_FILES);

            if (!empty($errors)) {
                setFlash('error', implode('<br>', $errors));

                $book->setTitle($title);
                $book->setAuthor($author);
                $book->setDescription($description);
                $book->setStatus($status);

                $this->render('edit-book', [
                    'title' => 'Modifier le livre',
                    'book' => $book
                ]);
                return;
            }

            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setDescription($description);
            $book->setStatus($status);
            $book->setSlug(Slugger::generate($title));

            if (
                isset($_FILES['image']) &&
                ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE
            ) {
                $uploadedImage = FileUploader::uploadBookImage($_FILES['image']);

                if ($uploadedImage === null) {
                    setFlash('error', 'Impossible d’enregistrer l’image.');

                    $this->render('edit-book', [
                        'title' => 'Modifier le livre',
                        'book' => $book
                    ]);
                    return;
                }

                $book->setImage($uploadedImage);
            }

            if ($this->bookManager->update($book)) {
                setFlash('success', 'Livre mis à jour avec succès.');
                redirect('/compte');
                return;
            }

            setFlash('error', 'Erreur lors de la mise à jour.');
        }

        $this->render('edit-book', [
            'title' => 'Modifier le livre',
            'book' => $book
        ]);
    }
    /**
     * Supprimer un livre par slug
     */

    public function delete(?string $slug): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        if (!$slug) {
            http_response_code(404);
            echo 'Livre introuvable';
            return;
        }

        $book = $this->bookManager->getBySlug($slug);

        if (!Authorizations::canManageBook($user, $book)) {
            setFlash('error', 'Accès interdit.');
            redirect('/compte');
            return;
        }

        if ($this->bookManager->deleteBySlug($slug)) {
            setFlash('success', 'Livre supprimé avec succès.');
        } else {
            setFlash('error', 'Erreur lors de la suppression.');
        }

        redirect('/compte');
    }
}
