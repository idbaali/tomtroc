<?php

namespace App\Controllers;

use App\Managers\BookManager;
use Core\Controller;
use App\Models\Book;

/**
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller
{
    /**
     * Page d'accueil avec les derniers livres
     */
    public function index(): void
    {
        // Instancie le manager
        $bookManager = new BookManager();

        // 🔥 Derniers livres ajoutés
        $books = $bookManager->getLatest(4);

        // On inclut la vue
        require __DIR__ . '/../views/home.php';
    }
}





