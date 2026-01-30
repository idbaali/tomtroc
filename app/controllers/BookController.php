<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Book;

/**
 * Contrôleur des livres
 * ---------------------
 * Récupère les données depuis le modèle Book et les envoie à la vue
 */
class BookController extends Controller
{
    private Book $bookModel;

    public function __construct()
    {
        parent::__construct();
        $this->bookModel = new Book();
    }

    /**
     * Liste de tous les livres
     */
    public function index()
    {
        $bookModel = new Book();

        // Récupère tous les livres depuis le modèle
        $books = $bookModel->getAll();

        // Affiche la vue 'books' avec la liste des livres
        $this->render('books', [
            'title' => 'Nos livres à l’échange',
            'books' => $books
        ]);
    }

    public function show($param)
    {
        // Si aucun paramètre reçu → erreur
        if (!$param) {
            http_response_code(404);
            echo "Livre introuvable";
            return;
        }

        // Si le paramètre est numérique → recherche par ID
        if (ctype_digit($param)) {
            $book = $this->bookModel->getById((int)$param);
        } else {
            // Sinon → recherche par slug
            $book = $this->bookModel->getBySlug($param);
        }

        // Si aucun livre trouvé
        if (!$book) {
            http_response_code(404);
            echo "Livre introuvable";
            return;
        }

        // Affichage de la vue book.php
        $this->render('book', [
            'title' => $book['title'],
            'book'  => $book
        ]);
    }

    /**
     * Enregistre un nouveau livre dans la base de données
     */
    public function store()
    {
        // Récupère les données envoyées via le formulaire
        $data = $_POST;

        // Générer le slug depuis le titre
        $slug = $this->generateSlug($data['title']);

        // Ajouter le slug aux données à enregistrer
        $data['slug'] = $slug;

        // Enregistrer le livre en base via le modèle
        $this->bookModel->create($data);

        // Rediriger vers la liste des livres
        header('Location: /livres');
    }

    /**
     * Modifier un livre
     */
    public function edit(?int $id): void
    {
        // Si l'id n'est pas fourni, erreur 404
        if (!$id) {
            http_response_code(404);
            $this->render('edit-book', ['book' => null]);
            return;
        }

        // Récupère le livre par son id
        $book = $this->bookModel->getById($id);

        // Si le livre n'existe pas, erreur 404
        if (!$book) {
            http_response_code(404);
        }

        // Affiche la vue d'édition
        $this->render('edit-book', ['book' => $book]);
    }

    /**
     * Génère un slug à partir du titre
     *
     * Exemple : "Wabi Sabi" => "wabi-sabi"
     *
     * @param string $title
     * @return string
     */
    private function generateSlug(string $title): string
    {
        // Met le titre en minuscules et enlève les espaces en début/fin
        $slug = strtolower(trim($title));

        // Remplace tous les caractères non alphanumériques par des tirets
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);

        // Remplace les tirets multiples par un seul tiret
        $slug = preg_replace('/-+/', '-', $slug);

        // Enlève les tirets au début et à la fin
        $slug = trim($slug, '-');

        return $slug;
        
    }
    
    
}
