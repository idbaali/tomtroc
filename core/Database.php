<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Classe Database
 * ----------------
 * Gère une instance UNIQUE de PDO (Singleton).
 * Permet d'éviter plusieurs connexions à la base de données.
 */
class Database
{
    /**
     * Instance PDO unique
     */
    private static ?PDO $pdo = null;

    /**
     * Retourne la connexion à la base
     */
    public static function getInstance(): PDO
    {
        // Si la connexion n'existe pas → on la crée
        if (self::$pdo === null) {

            try {

                self::$pdo = new PDO(
                    'mysql:host=' . DB_HOST .
                    ';port=' . DB_PORT .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                    DB_USER,
                    DB_PASS,
                    [
                        // 🔥 Active les exceptions SQL
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                        // 🔥 Retourne DIRECTEMENT des tableaux associatifs
                        // 👉 Ce qui permet de supprimer PDO::FETCH_ASSOC partout
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                        // 🔥 Désactive l'émulation (plus sécurisé)
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );

            } catch (PDOException $e) {

                // ⚠️ En production → ne JAMAIS afficher l'erreur SQL
                die('Erreur de connexion à la base de données.');
            }
        }

        return self::$pdo;
    }
}
