<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\MessageManager;
use App\Managers\UserManager;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    private MessageManager $messageManager;
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->messageManager = new MessageManager();
        $this->userManager = new UserManager();
    }

    public function index(?int $otherUserId = null): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
            
        }

        $currentUserId = $user->getId();

        if ($otherUserId === $currentUserId) {
            redirect('/messagerie');
            return;
        }

        $messages = [];
        $conversations = $this->messageManager->getUserConversations($currentUserId);
        $otherUser = null;

        if ($otherUserId) {
            $otherUser = $this->userManager->getById($otherUserId);

            if (!$otherUser) {
                setFlash('error', 'Utilisateur introuvable.');
                redirect('/messagerie');
                return;
            }

            $messages = $this->messageManager->getConversation($currentUserId, $otherUserId);
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

    public function send(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $receiverId = (int) ($_POST['receiver_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if (!$receiverId || $content === '') {
            setFlash('error', 'Message invalide.');
            redirect('/messagerie');
            return;
        }

        if ($receiverId === $user->getId()) {
            setFlash('error', 'Action invalide.');
            redirect('/messagerie');
            return;
        }

        $receiver = $this->userManager->getById($receiverId);

        if (!$receiver) {
            setFlash('error', 'Utilisateur introuvable.');
            redirect('/messagerie');
            return;
        }

        $sender = new User(['id' => $user->getId()]);

        $message = new Message([
            'content' => $content,
            'sender' => $sender,
            'receiver' => $receiver
        ]);

        if (!$this->messageManager->send($message)) {
            setFlash('error', 'Erreur lors de l’envoi du message.');
            redirect('/messagerie/' . $receiverId);
            return;
        }

        redirect('/messagerie/' . $receiverId);
    }
}