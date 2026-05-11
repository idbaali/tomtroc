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

    /**
     * Affiche la messagerie.
     * Si une conversation n'existe pas encore, elle s'ouvre vide.
     */
    public function index(?int $otherUserId = null): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $currentUserId = $user->getId();

        // Empêche d'ouvrir une conversation avec soi-même
        if ($otherUserId === $currentUserId) {
            redirect('/messagerie');
            return;
        }

        $messages = [];
        $otherUser = null;

        // Liste des conversations existantes
        $conversations = $this->messageManager->getUserConversations($currentUserId);

        // Si on arrive avec /messagerie/2
        if ($otherUserId !== null) {
            $otherUser = $this->userManager->getById($otherUserId);

            if (!$otherUser) {
                setFlash('error', 'Utilisateur introuvable.');
                redirect('/messagerie');
                return;
            }

            // Important :
            // même si aucun message n'existe, getConversation retourne []
            // donc la conversation vide s'affiche quand même.
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

    /**
     * Envoie un message.
     */
    public function send(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            setFlash('error', 'Vous devez être connecté.');
            redirect('/connexion');
            return;
        }

        $currentUserId = $user->getId();
        $receiverId = (int) ($_POST['receiver_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($receiverId <= 0 || $content === '') {
            setFlash('error', 'Message invalide.');
            redirect('/messagerie');
            return;
        }

        // Empêche l'envoi à soi-même
        if ($receiverId === $currentUserId) {
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

        $sender = new User([
            'id' => $currentUserId
        ]);

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