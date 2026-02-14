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

            // Nettoyage des entrées utilisateur
            $username = trim($_POST['pseudo'] ?? '');
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = trim($_POST['password'] ?? '');

            // Vérifier que tous les champs sont remplis
            if (empty($username) || empty($email) || empty($password)) {

                setFlash('error', "Tous les champs sont obligatoires.");
            }
            // ✅ Vérification du format de l'email
            elseif (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {

                setFlash('error', "Format d'email invalide.");
            } else {

                // 🔒 Hash sécurisé du mot de passe
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Enregistrement via le Manager
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

            // Récupération et nettoyage des entrées
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            // Récupérer l'utilisateur par email
            $user = $this->userManager->findByEmail($email);

            // Vérification sécurisée : email et mot de passe
            if (!$user || !password_verify($password, $user['password'])) {
                setFlash('error', "Email ou mot de passe incorrect");
                return; // arrêter l'exécution
            }

            // Supprimer le mot de passe avant de stocker en session
            unset($user['password']);
            $_SESSION['user'] = $user;

            setFlash('success', "Connexion réussie !");
            redirect('/compte');
        }

        // Affichage de la page de connexion
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
