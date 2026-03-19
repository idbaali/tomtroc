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

    public function account(): void
    {
        //  Vérifier connexion
        if (!isset($_SESSION['user'])) {
            redirect('/connexion');
        }

        // 🔹 Utilisateur connecté (objet)
        $user = $_SESSION['user'];

        // 🔹 Récupérer uniquement SES livres
        $books = $this->bookManager->getByUserId($user['id']);

        // 🔹 Envoyer à la vue
        $this->render('account', [
            'title' => 'Mon compte',
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Formulaire de création d'un livre
     */
    public function form(): void
    {
        // Vérifie que l'utilisateur est connecté
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

        // Récupère les données du formulaire
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = $_POST['image'] ?? 'default.png'; // tu peux gérer upload plus tard
        $slug = strtolower(str_replace(' ', '-', $title));

        $book = new Book([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'image' => $image,
            'owner_id' => $user['id'],
            'slug' => $slug
        ]);

        if ($this->bookManager->create($book)) {
            setFlash('success', 'Livre créé avec succès.');
            redirect('/compte');
        } else {
            setFlash('error', 'Erreur lors de la création du livre.');
            redirect('/livre/creer');
        }
    }

    /**
     * Formulaire d'édition d'un livre
     */
    public function edit(int $id): void
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $book = $this->bookManager->getById($id);

        if (!$book || $book->getOwnerId() !== $user['id']) {
            setFlash('error', 'Action non autorisée.');
            redirect('/compte');
            return;
        }

        $this->render('edit-book', [
            'title' => 'Modifier le livre',
            'book' => $book
        ]);
    }

    /**
     * Mise à jour d'un livre
     */
    public function update(int $id): void
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $book = $this->bookManager->getById($id);
        if (!$book || $book->getOwnerId() !== $user['id']) {
            setFlash('error', 'Action non autorisée.');
            redirect('/compte');
            return;
        }

        $book->setTitle($_POST['title'] ?? $book->getTitle());
        $book->setAuthor($_POST['author'] ?? $book->getAuthor());
        $book->setDescription($_POST['description'] ?? $book->getDescription());
        $book->setImage($_POST['image'] ?? $book->getImage());

        if ($this->bookManager->update($book)) {
            setFlash('success', 'Livre mis à jour avec succès.');
        } else {
            setFlash('error', 'Erreur lors de la mise à jour.');
        }

        redirect('/compte');
    }

    /**
     * Suppression d'un livre
     */
    public function delete(int $id): void
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $book = $this->bookManager->getById($id);
        if (!$book || $book->getOwnerId() !== $user['id']) {
            setFlash('error', 'Action non autorisée.');
            redirect('/compte');
            return;
        }

        if ($this->bookManager->delete($id)) {
            setFlash('success', 'Livre supprimé avec succès.');
        } else {
            setFlash('error', 'Erreur lors de la suppression.');
        }

        redirect('/compte');
    }
}
