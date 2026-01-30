<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['pseudo'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
            } else {

                // 🔒 Hash du mot de passe
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Enregistrer en base
                $this->userModel->create($username, $email, $passwordHash);

                header('Location: /connexion');
                exit;
            }
        }

        require __DIR__ . '/../views/register.php';
    }
    public function login()
    {
        $error = ''; // ✅ IMPORTANT : définir $error

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userModel->findByEmail($email);

            if (!$user) {
                setFlash('error', "Email incorrect");
            } elseif (!password_verify($password, $user['password'])) {
                setFlash('error', "Mot de passe incorrect");
            } else {
                unset($user['password']);
                $_SESSION['user'] = $user;

                setFlash('success', "Connexion réussie !");
                header('Location: /compte');
                exit;
            }
        }

        require __DIR__ . '/../views/login.php';
    }

    public function logout()
    {
        session_destroy();

        session_start();
        setFlash('info', "Vous êtes déconnecté.");

        header('Location: /');
        exit;
    }
}
