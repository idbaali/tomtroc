<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Book;

/**
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller
{
    private Book $bookModel;

    public function __construct()
    {
        parent::__construct();
        $this->bookModel = new Book();
    }

    /**
     * Page d'accueil avec les derniers livres
     */
    public function index(): void
    {
         $bookModel = new Book();

        // 🔥 Derniers livres ajoutés
        $books = $bookModel->getLatest(4);

        require __DIR__ . '/../views/home.php';
    }
}

