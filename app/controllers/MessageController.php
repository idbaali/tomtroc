<?php

namespace App\Controllers;

use Core\Controller;
use App\Managers\MessageManager;

class MessageController extends Controller
{
    private MessageManager $messageManager;

    public function __construct()
    {
        parent::__construct();
        $this->messageManager = new MessageManager();
    }

    public function index()
    {
        // ✅ Vérifier AVANT tout
        if (!isset($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $messages = $this->messageManager->findByUser($userId);

        $this->render('messages', [
            'messages' => $messages
        ]);
    }
}
