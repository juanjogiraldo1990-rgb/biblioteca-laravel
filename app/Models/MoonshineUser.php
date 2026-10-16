<?php

namespace App\Models;

use MoonShine\Laravel\Models\MoonshineUser as BaseMoonshineUser;

class MoonshineUser extends BaseMoonshineUser
{
    /**
     * Verificar si el usuario es Administrador (ID 1).
     */
    public function isAdmin(): bool
    {
        return $this->moonshine_user_role_id === 1;
    }

    /**
     * Verificar si el usuario es Bibliotecario (ID 2).
     */
    public function isBibliotecario(): bool
    {
        return $this->moonshine_user_role_id === 2;
    }

    /**
     * Verificar si el usuario es Lector (ID 3).
     */
    public function isLector(): bool
    {
        return $this->moonshine_user_role_id === 3;
    }
}