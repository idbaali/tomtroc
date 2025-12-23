<?php
require_once '../core/Database.php';

class User extends Database
{
    public function getFirstUser()
    {
        $stmt = $this->pdo->prepare("SELECT username FROM users LIMIT 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
