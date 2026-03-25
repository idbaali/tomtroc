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
     * 👤 COMPTE UTILISATEUR CONNECTÉ
     */
    public function account(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        // ✅ On récupère uniquement SES livres
        $books = $this->bookManager->getByUserId($user['id']);

        $this->render('account', [
            'title' => 'Mon compte',
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * 🌍 PROFIL PUBLIC
     * 🎯 OBJECTIF MENTOR :
     * → UNE SEULE requête (jointure)
     */
    public function profile(int $id): void
    {
        if (!$id) {
            http_response_code(404);
            echo "Utilisateur introuvable";
            return;
        }

        /**
         * ✅ UNE SEULE requête SQL
         * (user + livres)
         */
        $result = $this->userManager->getUserWithBooks($id);

        if (!$result) {
            http_response_code(404);
            echo "Utilisateur introuvable";
            return;
        }

        // ✅ On récupère les objets
        $user = $result['user'];
        $books = $result['books'];

        /**
         * ✅ Envoi à la vue
         */
        $this->render('profile', [
            'title' => 'Profil de ' . $user->getUsername(),
            'user' => $user,
            'books' => $books
        ]);
    }
}