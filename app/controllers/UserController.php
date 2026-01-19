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
    public function account()
    {
        $user = $this->userModel->getById(1); // Remplacer par l'utilisateur connecté
        $this->render('account', ['user' => $user]);
    }

    /**
     * Page Profil
     */
    public function profile()
    {
        $user = $this->userModel->getById(1); // Exemple temporaire
        $this->render('profile', ['user' => $user]);
    }

    /**
     * Bibliothèque personnelle de l'utilisateur
     */
    public function library()
    {
        $books = $this->bookModel->getByOwner(1); // Exemple : id utilisateur = 1
        $this->render('library', ['books' => $books]);
    }
}
