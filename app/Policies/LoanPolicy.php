<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\MoonshineUser;

class LoanPolicy
{
    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Loan $loan): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function update(MoonshineUser $user, Loan $loan): bool
    {
        return $user->isAdmin() || $user->isBibliotecario();
    }

    public function delete(MoonshineUser $user, Loan $loan): bool
    {
        return $user->isAdmin();
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $user->isAdmin();
    }
}