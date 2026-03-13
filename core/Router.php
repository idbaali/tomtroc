<?php

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\BookController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\MessageController;

class Router
{
    public function run()
    {
        // 🔐 Session (OBLIGATOIRE ici)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Récupération de l’URL sans les paramètres GET (?page=...)
        // Exemple :
        //   /livre/wabi-sabi?test=1  →  livre/wabi-sabi
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // 2. Découpage de l’URL en segments
        // Exemple :
        //   livre/wabi-sabi → ['livre', 'wabi-sabi']
        $segments = explode('/', $uri);

        // 3. Définition des variables principales
        // $page  = premier segment de l’URL
        // $param = deuxième segment (slug ou id)
        $page  = $segments[0] ?? '';
        $param = $segments[1] ?? null;

        // 3. Routes publiques (ACCESSIBLES SANS CONNEXION)
        $publicRoutes = ['', 'connexion', 'inscription', 'livres', 'livre', 'compte-public'];

        // 🔐 Protection des routes
        if (!isset($_SESSION['user']) && !in_array($page, $publicRoutes)) {
            header('Location: /connexion');
            exit;
        }

        // 4. Analyse de la route demandée
        switch ($page) {

            // 5. Accueil → /
            case '':
                $controller = new HomeController();
                $controller->index();
                break;

            // Liste de tous les livres
            case 'livres':
                $controller = new BookController();
                $controller->index();
                break;

            // Affichage d’un livre par ID ou slug
            case 'livre':
                $controller = new BookController();
                $controller->show($param);
                break;

            // Création d’un livre
            // case 'ajouter-livre':
            //     $controller = new BookController();
            //     $controller->create();
            //     break;

            // Modification d’un livre → /edition-livre/12
            case 'edition-livre':
                $controller = new BookController();
                $controller->edit($param);
                break;

            // Suppression d’un livre → /supprimer-livre/12
            // case 'supprimer-livre':
            //     $controller = new BookController();
            //     $controller->delete($param);
            //     break;

            case 'compte-public':
                $controller = new UserController();
                $id = $_GET['id'] ?? null;
                $controller->profile($id);
                break;


            // Connexion
            case 'connexion':
                $controller = new AuthController();
                $controller->login();
                break;

            // Déconnexion
            case 'deconnexion':
                $controller = new AuthController();
                $controller->logout();
                break;

            // Inscription
            case 'inscription':
                $controller = new AuthController();
                $controller->register();
                break;

            // Compte utilisateur connecté
            case 'compte':
                $controller = new UserController();
                $controller->account();
                break;

            // Messagerie (AFFICHAGE + ENVOI)
            case 'messagerie':
                $controller = new MessageController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Envoi message
                    $controller->send();
                } else {
                    // Affichage messagerie
                    $controller->index();
                }
                break;


            // 404 pour toutes les autres routes
            default:
                http_response_code(404);
                echo "Page non trouvée";
        }
    }
}
