<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\UserManager;
use App\Managers\BookManager;

class UserController extends Controller
{
    private UserManager $userManager;
    private BookManager $bookManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
        $this->bookManager = new BookManager();
    }

    /**
     * Compte utilisateur connecté
     */
    public function account(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $books = $this->bookManager->getByUserId($user->getId());

        $this->render('account', [
            'title' => 'Mon compte',
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Profil public
     */
    public function profile(int $id): void
    {
        if (!$id) {
            http_response_code(404);
            echo 'Utilisateur introuvable';
            return;
        }

        $user = $this->userManager->getUserWithBooks($id);

        if (!$user) {
            http_response_code(404);
            echo 'Utilisateur introuvable';
            return;
        }

        $this->render('profile', [
            'title' => 'Profil de ' . $user->getUsername(),
            'user' => $user
        ]);
    }
}