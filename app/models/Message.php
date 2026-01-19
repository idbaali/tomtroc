<?php

namespace App\Models;

use PDO;
use Core\Database;

/**
 * Modèle Message
 * ---------------
 * Gère toutes les opérations liées aux messages privés
 */
class Message
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère tous les messages reçus par un utilisateur
     */
    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM messages
            WHERE receiver_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
