<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\MoonshineUser;

class AuthorPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Author $author): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }

    public function update(MoonshineUser $user, Author $author): bool
    {
        return $user->isAdmin();
    }

    public function delete(MoonshineUser $user, Author $author): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}