<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\UserManager;
use App\Managers\BookManager;

class UserController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    /**
     * Page du compte connecté
     */
    public function account(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $bookManager = new BookManager();
        $books = $bookManager->getByUserId($user['id']);

        // Si aucun livre, on met un exemple pour tester l'affichage
        if (empty($books)) {
            $books = [
                [
                    'title' => 'The Kinfolk Table',
                    'author' => 'Nathan Williams',
                    'description' => 'J\'ai récemment plongé dans les pages de "The Kinfolk Table"...',
                    'available' => true,
                    'photo' => 'kinfolk.png'
                ],
                [
                    'title' => 'Autre Livre',
                    'author' => 'Auteur X',
                    'description' => 'Description du livre…',
                    'available' => false,
                    'photo' => 'default.png'
                ]
            ];
        }

        $this->render('account', [
            'title' => 'Mon compte',
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Profil public d'un utilisateur
     */
    public function profile(int $id): void
    {
        $bookManager = new BookManager();

        // Récupérer l'utilisateur via UserManager
        $user = $this->userManager->getById($id);

        if (!$user) {
            http_response_code(404);
            echo "Utilisateur introuvable";
            return;
        }

        // Récupérer tous les livres de l'utilisateur
        $books = $bookManager->getByUserId($user->getId());

        $this->render('profile', [
            'title' => ($user->getUsername() ?? 'Utilisateur') . ' - Profil',
            'user' => $user,
            'books' => $books
        ]);
    }
}