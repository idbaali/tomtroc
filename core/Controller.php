<?php

class Controller
{
    protected function render($view)
    {
        require_once '../app/views/layout/header.php';
        require_once "../app/views/$view.php";
        require_once '../app/views/layout/footer.php';
    }
}
