<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\Message;

/**
 * MessageManager
 * -----------------
 * Gère les opérations liées aux messages.
 */
class MessageManager extends BaseManager
{
    /**
     * 🔵 Envoie un message
     */
    public function send(Message $message): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO messages (sender_id, receiver_id, content)
            VALUES (:sender, :receiver, :content)
        ");

        return $stmt->execute([
            'sender' => $message->getSenderId(),
            'receiver' => $message->getReceiverId(),
            'content' => $message->getContent()
        ]);
    }

    /**
     * 🔵 Récupère une conversation complète
     * entre deux utilisateurs
     */
    public function getConversation(int $user1, int $user2): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM messages
            WHERE (sender_id = :u1 AND receiver_id = :u2)
               OR (sender_id = :u2 AND receiver_id = :u1)
            ORDER BY created_at ASC
        ");

        $stmt->execute([
            'u1' => $user1,
            'u2' => $user2
        ]);

        return $stmt->fetchAll();
    }

    /**
     * 🔵 Liste des utilisateurs avec qui l'utilisateur
     * a déjà échangé des messages
     */
    public function getUserConversations(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT DISTINCT u.id, u.username, u.avatar
            FROM users u
            INNER JOIN messages m
                ON (u.id = m.sender_id OR u.id = m.receiver_id)
            WHERE u.id != :userId
              AND (m.sender_id = :userId OR m.receiver_id = :userId)
        ");

        // 🔹 Même paramètre : ':userId' utilisé deux fois dans SQL
        // PDO accepte ça si on passe un seul paramètre associatif
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll();
    }
}
