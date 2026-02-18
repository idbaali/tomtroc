<?php

namespace App\Managers;

use PDO;
use Core\Database;

class MessageManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère tous les messages reçus par un utilisateur
     */
    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM messages
            WHERE receiver_id = :userId
            ORDER BY created_at DESC
        ");

        $stmt->execute([
            'userId' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
