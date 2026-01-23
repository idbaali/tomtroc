<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Message;

/**
 * Contrôleur des messages
 * -----------------------
 * Récupère les messages reçus par l'utilisateur
 */
class MessageController extends Controller
{
    private Message $messageModel;

    public function __construct()
    {
        parent::__construct();
        $this->messageModel = new Message();
    }

    /**
     * Liste des messages reçus
     */
    public function index()
    {
        $messages = $this->messageModel->getByUser(1); // Exemple : utilisateur connecté = 1
        $this->render('messages', ['messages' => $messages]);

        if (!isset($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }
    }
}
