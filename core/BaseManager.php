<?php

namespace Core;

use PDO;

/**
 * Class BaseManager
 * -----------------
 * Manager parent de tous les managers.
 *
 * 👉 Centralise la connexion à la base de données
 * pour éviter la duplication de code.
 */
abstract class BaseManager
{
    protected PDO $db;

    public function __construct()
    {
        // Connexion unique partagée par tous les managers
        $this->db = Database::getInstance();
    }
}


