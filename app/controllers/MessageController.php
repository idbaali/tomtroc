<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\MessageManager;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    private MessageManager $messageManager;

    public function __construct()
    {
        parent::__construct();
        $this->messageManager = new MessageManager();
    }

    /**
     * Afficher la messagerie
     */
    public function index(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $currentUserId = $user->getId();
        $otherUserId = isset($_GET['user']) ? (int) $_GET['user'] : null;

        $messages = [];
        $conversations = $this->messageManager->getUserConversations($currentUserId);
        $otherUser = null;

        if ($otherUserId) {
            $messages = $this->messageManager->getConversation($currentUserId, $otherUserId);

            foreach ($conversations as $conversation) {
                $sender = $conversation->getSender();
                $receiver = $conversation->getReceiver();

                $candidate = ($sender->getId() === $currentUserId) ? $receiver : $sender;

                if ($candidate && $candidate->getId() === $otherUserId) {
                    $otherUser = $candidate;
                    break;
                }
            }
        }

        $this->render('messagerie', [
            'title' => 'Messagerie',
            'messages' => $messages,
            'conversations' => $conversations,
            'currentUserId' => $currentUserId,
            'otherUserId' => $otherUserId,
            'otherUser' => $otherUser
        ]);
    }

    /**
     * Envoyer un message
     */
    public function send(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $receiverId = isset($_POST['receiver_id']) ? (int) $_POST['receiver_id'] : 0;
        $content = trim($_POST['content'] ?? '');

        if (!$receiverId || $content === '') {
            setFlash('error', 'Message invalide.');
            redirect('/messagerie');
            return;
        }

        $sender = new User(['id' => $user->getId()]);
        $receiver = new User(['id' => $receiverId]);

        $message = new Message([
            'content' => $content,
            'sender' => $sender,
            'receiver' => $receiver
        ]);

        $this->messageManager->send($message);

        redirect('/messagerie?user=' . $receiverId);
    }
}