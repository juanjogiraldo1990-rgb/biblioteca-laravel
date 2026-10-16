<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\MoonshineUser;

class CategoryPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Category $category): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }

    public function update(MoonshineUser $user, Category $category): bool
    {
        return $user->isAdmin();
    }

    public function delete(MoonshineUser $user, Category $category): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}