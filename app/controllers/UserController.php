<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\Book;

/**
 * Contrôleur utilisateur
 * ----------------------
 * Gère compte, profil et bibliothèque personnelle
 */
class UserController extends Controller
{
    private User $userModel;
    private Book $bookModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->bookModel = new Book();
    }

    /**
     * Page Mon compte
     */
    public function account(): void
    {
        // 1️⃣ Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user']['id'])) {
            header('Location: /connexion');
            exit;
        }

        // 2️⃣ Récupérer l'utilisateur connecté
        $userId = (int) $_SESSION['user']['id'];
        $user   = $this->userModel->getById($userId);

        // 3️⃣ Récupérer ses livres
        $books = $this->bookModel->getByOwner($userId);

        // 4️⃣ Afficher la vue
        $this->render('account', [
            'user'  => $user,
            'books' => $books
        ]);
    }

    /**
     * Page Profil
     */
    public function profile(int $id): void
    {
        // 1️⃣ Récupérer l'utilisateur demandé
        $user = $this->userModel->getById($id);

        if (!$user) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        // 2️⃣ Récupérer les livres de cet utilisateur
        $books = $this->bookModel->getByOwner($id);

        // 3️⃣ Affichage
        $this->render('profile', [
            'user'  => $user,
            'books' => $books
        ]);
    }
}
