<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\Message;

/**
 * MessageManager
 * -----------------
 * Gère les opérations liées aux messages :
 * - Envoi de message
 * - Récupération de conversations
 * - Récupération des messages entre utilisateurs
 */
class MessageManager extends BaseManager
{
    /**
     * 🔵 Envoie un message
     *
     * @param Message $message
     * @return bool
     */
    public function send(Message $message): bool
    {
        // 🔹 Préparation de la requête SQL pour insérer un message
        $stmt = $this->db->prepare("
            INSERT INTO messages (sender_id, receiver_id, content)
            VALUES (:sender, :receiver, :content)
        ");

        // 🔹 Exécution avec paramètres nommés
        return $stmt->execute([
            'sender'   => $message->getSenderId(),
            'receiver' => $message->getReceiverId(),
            'content'  => $message->getContent()
        ]);
    }

    /**
     * 🔵 Récupère une conversation complète
     * entre deux utilisateurs triée par date
     *
     * @param int $user1 ID du premier utilisateur
     * @param int $user2 ID du second utilisateur
     * @return array
     */
    public function getConversation(int $user1, int $user2): array
    {
        // 🔹 Requête SQL pour tous les messages échangés entre deux utilisateurs
        $stmt = $this->db->prepare("
            SELECT *
            FROM messages
            WHERE (sender_id = :u1 AND receiver_id = :u2)
               OR (sender_id = :u2 AND receiver_id = :u1)
            ORDER BY created_at ASC
        ");

        // 🔹 Exécution avec paramètres nommés
        $stmt->execute([
            'u1' => $user1,
            'u2' => $user2
        ]);

        // 🔹 Retourne les messages sous forme de tableau associatif
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 🔵 Récupère tous les utilisateurs avec qui
     * l'utilisateur a déjà échangé des messages
     *
     * @param int $userId ID de l'utilisateur courant
     * @return array
     */
    /**
     * 🔵 Récupère toutes les conversations d’un utilisateur
     */
    public function getUserConversations(int $userId): array
    {
        // 🔹 On sélectionne les messages où l'utilisateur est soit sender soit receiver
        // 🔹 On utilise CASE pour déterminer l'autre personne dans la conversation
        $sql = "
        SELECT m.*,
               CASE
                   WHEN sender_id = ? THEN receiver_id
                   ELSE sender_id
               END AS other_user_id
        FROM messages m
        WHERE sender_id = ? OR receiver_id = ?
        ORDER BY created_at DESC
    ";

        $stmt = $this->db->prepare($sql);

        // 🔹 Attention ici : les '?' doivent être fournis dans le bon ordre
        $stmt->execute([$userId, $userId, $userId]);

        $allMessages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 🔹 On ne garde qu'un message par conversation (le dernier)
        $conversations = [];
        foreach ($allMessages as $msg) {
            $otherId = $msg['other_user_id'];
            if (!isset($conversations[$otherId])) {
                $conversations[$otherId] = $msg;
            }
        }

        return array_values($conversations);
    }
}
