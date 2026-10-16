<?php

namespace App\Policies;

use App\Models\Editorial;
use App\Models\MoonshineUser;

class EditorialPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Editorial $editorial): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }

    public function update(MoonshineUser $user, Editorial $editorial): bool
    {
        return $user->isAdmin();
    }

    public function delete(MoonshineUser $user, Editorial $editorial): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}