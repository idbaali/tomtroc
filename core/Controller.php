<?php
namespace Core;

use PDO;

// ✅ Chargement des helpers une seule fois
require_once __DIR__ . '/../app/helpers.php';

abstract class Controller
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function render(string $view, array $data = [])
    {
        extract($data);
        require __DIR__ . '/../app/views/' . $view . '.php';
    }

    
}


