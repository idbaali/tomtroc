<?php

require_once '../core/Controller.php';
require_once '../app/controllers/HomeController.php';

class Router
{
    public function run()
    {
        $controller = new HomeController();
        $controller->index();
    }
}
