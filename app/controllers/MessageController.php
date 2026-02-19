<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\MessageManager;

/**
 * Contrôleur de la messagerie
 * ----------------------------
 * Permet d'afficher les conversations, les messages
 * et d'envoyer de nouveaux messages.
 */
class MessageController extends Controller
{
    private MessageManager $messageManager;

    public function __construct()
    {
        parent::__construct();
        $this->messageManager = new MessageManager();
    }

    /**
     * Liste des conversations et affichage des messages
     */
    public function index(): void
    {
        // 🔹 ID de l'utilisateur connecté
        $userId = $_SESSION['user']['id'];

        // 🔹 Récupère toutes les conversations de l'utilisateur
        $conversations = $this->messageManager->getUserConversations($userId);

        // 🔹 ID de l'utilisateur sélectionné pour voir la conversation
        $currentConversationUserId = $_GET['user'] ?? null;

        // 🔹 Messages à afficher (vide si aucune conversation sélectionnée)
        $messages = [];
        if ($currentConversationUserId) {
            $currentConversationUserId = (int)$currentConversationUserId;
            $messages = $this->messageManager->getConversation($userId, $currentConversationUserId);
        }

        // 🔹 Affiche la vue messagerie.php
        $this->render('messagerie', [
            'title' => 'Messagerie',
            'conversations' => $conversations,
            'messages' => $messages,
            'currentConversationUserId' => $currentConversationUserId
        ]);
    }

    /**
     * Envoi d'un nouveau message
     */
    public function send(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $senderId = $_SESSION['user']['id'];
        $receiverId = (int)($_POST['receiver_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        // 🔹 Vérifie que le message est valide
        if ($receiverId && $content) {
            $message = new \App\Models\Message([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'content' => $content
            ]);

            $this->messageManager->send($message);
        }

        // 🔹 Redirection vers la conversation après envoi
        redirect("/messagerie?user={$receiverId}");
    }
}
