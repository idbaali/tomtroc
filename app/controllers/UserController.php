<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\UserManager;
use App\Managers\BookManager;
use App\Models\User;

class UserController extends Controller
{
    private UserManager $userManager;
    private BookManager $bookManager;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
        $this->bookManager = new BookManager();
        $this->userModel = new User();
    }

    /**
     * COMPTE UTILISATEUR CONNECTÉ
     */
    public function account(): void
    {
        $user = $_SESSION['user'] ?? null;

        // var_dump($_SESSION['user']);
        // die;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        // On récupère uniquement SES livres
        $books = $this->bookManager->getByUserId($user->getId());



        $this->render('account', [
            'title' => 'Mon compte',
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * PROFIL PUBLIC
     * OBJECTIF MENTOR :
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
         * UNE SEULE requête SQL
         * (user + livres)
         */
        $result = $this->userManager->getUserWithBooks($id);


        if (!$result) {
            http_response_code(404);
            echo "Utilisateur introuvable";
            return;
        }

        // On récupère les objets
        /**
         * Envoi à la vue
         */
        $this->render('profile', [
            'title' => 'Profil de ' . $result->getUsername(),
            'user' => $result
        ]);
    }
}
