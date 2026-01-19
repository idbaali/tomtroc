<?php

namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        // Page connexion
        $this->render('login');
    }

    public function register()
    {
        // Page inscription
        $this->render('register');
    }
}

