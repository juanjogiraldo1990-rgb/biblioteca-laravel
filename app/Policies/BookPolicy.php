<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\MoonshineUser;

class BookPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Book $book): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function update(MoonshineUser $user, Book $book): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function delete(MoonshineUser $user, Book $book): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}