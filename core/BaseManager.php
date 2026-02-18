<?php

namespace Core;

use PDO;

abstract class BaseManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
