<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\UserManager;

class AuthController extends Controller
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    /**
     * Page d'inscription
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['pseudo'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($email) || empty($password)) {
                setFlash('error', "Tous les champs sont obligatoires.");
            } else {
                // 🔒 Hash du mot de passe
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Enregistrer en base via UserManager
                $success = $this->userManager->create($username, $email, $passwordHash);

                if (!$success) {
                    setFlash('error', "Cet email est déjà utilisé.");
                } else {
                    setFlash('success', "Inscription réussie !");
                    redirect('/connexion');
                }
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    /**
     * Page de connexion
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userManager->findByEmail($email);

            if (!$user) {
                setFlash('error', "Email incorrect");
            } elseif (!password_verify($password, $user['password'])) {
                setFlash('error', "Mot de passe incorrect");
            } else {
                unset($user['password']);
                $_SESSION['user'] = $user;

                setFlash('success', "Connexion réussie !");
                redirect('/compte');
            }
        }

        require __DIR__ . '/../views/login.php';
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session_destroy();

        session_start();
        setFlash('info', "Vous êtes déconnecté.");

        redirect('/');
    }
}
