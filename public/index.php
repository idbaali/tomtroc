<?php
require_once '../app/helpers.php';




// require_once __DIR__ . '/../vendor/autoload.php';

/**
 * FRONT CONTROLLER
 * ----------------
 * Toutes les requêtes HTTP passent par ce fichier
 * grâce au fichier public/.htaccess
 */

// 1. Chargement de la configuration globale
// (connexion DB, constantes, etc.)
require_once __DIR__ . '/../config/config.php';

// 2. Autoloader simple (sans Composer)
// Permet de charger automatiquement les classes PHP
spl_autoload_register(function ($class) {
    // Préfixes de namespaces utilisés dans le projet
    $prefixApp = 'App\\';
    $prefixCore = 'Core\\';

    // Dossiers correspondants
    $baseDirApp = __DIR__ . '/../app/';
    $baseDirCore = __DIR__ . '/../core/';

    // Chargement des classes App\
    if (str_starts_with($class, $prefixApp)) {

        // Suppression du namespace App\
        $relativeClass = substr($class, strlen($prefixApp));

        // Construction du chemin du fichier
        $file = $baseDirApp . str_replace('\\', '/', $relativeClass) . '.php';

        // Inclusion du fichier s’il existe
        if (file_exists($file)) {
            require $file;
        }
    }

    // Chargement des classes Core\
    elseif (str_starts_with($class, $prefixCore)) {

        // Suppression du namespace Core\
        $relativeClass = substr($class, strlen($prefixCore));

        // Construction du chemin du fichier
        $file = $baseDirCore . str_replace('\\', '/', $relativeClass) . '.php';

        // Inclusion du fichier s’il existe
        if (file_exists($file)) {
            require $file;
        }
    }
});

use Core\Router;

// 3. Création du routeur
$router = new Router();

// 4. Lancement du routage
$router->run();
