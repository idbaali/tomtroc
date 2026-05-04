<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;

class Authorizations
{
    /**
     * Vérifie si un utilisateur peut gérer un livre
     */
    public static function canManageBook(?User $user, ?Book $book): bool
    {
        if (!$user || !$book) {
            return false;
        }

        return (int) $book->getOwnerId() === (int) $user->getId();
    }
}