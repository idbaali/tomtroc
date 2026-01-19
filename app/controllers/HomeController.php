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
        $latestBooks = $bookModel->getLatest(4); // 4 derniers livres
        $this->render('home', [
            'latestBooks' => $latestBooks,
            'title' => 'Accueil - TomTroc'
        ]);
    }
}
