<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\MoonshineUser;

class MemberPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Member $member): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function update(MoonshineUser $user, Member $member): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function delete(MoonshineUser $user, Member $member): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}