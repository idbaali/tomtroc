<?php

namespace App\Managers;

use Core\BaseManager;
use App\Models\Message;
use App\Models\User;

class MessageManager extends BaseManager
{
    /**
     * Envoyer un message
     */
    public function send(Message $message): bool
    {
        $sender = $message->getSender();
        $receiver = $message->getReceiver();

        if (!$sender || !$receiver) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO messages (sender_id, receiver_id, content)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $sender->getId(),
            $receiver->getId(),
            $message->getContent()
        ]);
    }

    /**
     * Conversation entre deux utilisateurs
     */
    public function getConversation(int $user1, int $user2): array
    {
        $stmt = $this->db->prepare("
        SELECT
            m.*,

            sender.id AS sender_id,
            sender.username AS sender_username,
            sender.email AS sender_email,
            sender.password AS sender_password,
            sender.avatar AS sender_avatar,
            sender.created_at AS sender_created_at,

            receiver.id AS receiver_id,
            receiver.username AS receiver_username,
            receiver.email AS receiver_email,
            receiver.password AS receiver_password,
            receiver.avatar AS receiver_avatar,
            receiver.created_at AS receiver_created_at

        FROM messages m
        JOIN users sender ON sender.id = m.sender_id
        JOIN users receiver ON receiver.id = m.receiver_id

        WHERE (m.sender_id = :u1 AND m.receiver_id = :u2)
           OR (m.sender_id = :u3 AND m.receiver_id = :u4)

        ORDER BY m.created_at ASC
    ");

        $stmt->execute([
            'u1' => $user1,
            'u2' => $user2,
            'u3' => $user2,
            'u4' => $user1
        ]);

        return $this->hydrateMessages($stmt);
    }
    /**
     * Liste des conversations
     */
    public function getUserConversations(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                m.*,

                sender.id AS sender_id,
                sender.username AS sender_username,
                sender.email AS sender_email,
                sender.password AS sender_password,
                sender.avatar AS sender_avatar,
                sender.created_at AS sender_created_at,

                receiver.id AS receiver_id,
                receiver.username AS receiver_username,
                receiver.email AS receiver_email,
                receiver.password AS receiver_password,
                receiver.avatar AS receiver_avatar,
                receiver.created_at AS receiver_created_at

            FROM messages m
            JOIN users sender ON sender.id = m.sender_id
            JOIN users receiver ON receiver.id = m.receiver_id

            WHERE m.id IN (
                SELECT MAX(id)
                FROM messages
                WHERE sender_id = ? OR receiver_id = ?
                GROUP BY LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
            )

            ORDER BY m.created_at DESC
        ");

        $stmt->execute([$userId, $userId]);

        return $this->hydrateMessages($stmt);
    }

    /**
     * Hydratation → objets Message
     */
    private function hydrateMessages(\PDOStatement $stmt): array
    {
        $messages = [];

        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $messages[] = $this->hydrateMessage($data);
        }

        return $messages;
    }

    /**
     * Hydratation d’un Message
     */
    private function hydrateMessage(array $data): Message
    {
        $sender = new User([
            'id' => $data['sender_id'],
            'username' => $data['sender_username'],
            'email' => $data['sender_email'],
            'password' => $data['sender_password'],
            'avatar' => $data['sender_avatar'],
            'created_at' => $data['sender_created_at']
        ]);

        $receiver = new User([
            'id' => $data['receiver_id'],
            'username' => $data['receiver_username'],
            'email' => $data['receiver_email'],
            'password' => $data['receiver_password'],
            'avatar' => $data['receiver_avatar'],
            'created_at' => $data['receiver_created_at']
        ]);

        return new Message([
            'id' => $data['id'],
            'content' => $data['content'],
            'created_at' => $data['created_at'],
            'sender' => $sender,
            'receiver' => $receiver
        ]);
    }
}
