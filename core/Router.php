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
        // Nettoyage de l'URL (sans paramètres GET)
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
                $controller = new \App\Controllers\HomeController();
                $controller->index();
                break;

            case 'livres':   // au lieu de 'books'
                $controller = new \App\Controllers\BookController();
                $controller->index();
                break;

            case 'livre':    // au lieu de 'book'
                $controller = new \App\Controllers\BookController();
                $controller->show($param);
                break;

            case 'connexion':
                $controller = new \App\Controllers\AuthController();
                $controller->login();
                break;

            case 'deconnexion':
                $controller = new \App\Controllers\AuthController();
                $controller->logout();
                break;

            case 'inscription': // au lieu de 'register'
                $controller = new \App\Controllers\AuthController();
                $controller->register();
                break;

            case 'compte':    // au lieu de 'account'
                $controller = new \App\Controllers\UserController();
                $controller->account();
                break;

            case 'compte-public':    // au lieu de 'profile'
                $controller = new \App\Controllers\UserController();
                $controller->profile();
                break;

            case 'bibliotheque': // au lieu de 'library'
                $controller = new \App\Controllers\UserController();
                $controller->library();
                break;

            case 'messages':
                $controller = new \App\Controllers\MessageController();
                $controller->index();
                break;

            // Modification d’un livre → /modifier-livre/12
            // 6. Fonctionne, mais pourra évoluer plus tard

            case 'edition-livre': // au lieu de 'edit-book'
                $controller = new \App\Controllers\BookController();
                $controller->edit($param);
                break;


            default:
                http_response_code(404);
                echo "Page non trouvée";
        }
    }
}
