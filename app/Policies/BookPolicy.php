<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\MoonshineUser;

class BookPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true; // Todos pueden ver la tabla
    }

    public function view(MoonshineUser $user, Book $book): bool
    {
        return true; // Todos pueden ver el detalle
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function update(MoonshineUser $user, Book $book): bool
    {
        return $user->isAdmin() || $user->isBibliotecario(); // Admin y Bibliotecario pueden editar
    }

    public function delete(MoonshineUser $user, Book $book): bool
    {
        return $user->isAdmin(); // Solo el Admin puede borrar
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}