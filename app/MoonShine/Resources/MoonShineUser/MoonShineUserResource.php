<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUser;

use App\Models\MoonshineUser;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserFormPage;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Ability;
use MoonShine\Support\Enums\Action;

/**
 * @extends ModelResource<MoonshineUser, MoonShineUserIndexPage, MoonShineUserFormPage>
 */
class MoonShineUserResource extends ModelResource
{
    protected string $model = MoonshineUser::class;

    protected string $title = 'Admins';

    protected string $column = 'name';

    /**
     * Bloquear acciones específicas si no es Admin
     */
    public function isCan(Ability $ability): bool
    {
        // Si el usuario NO es Admin (es decir, es Lector o Bibliotecario)
        if (! auth('moonshine')->user()?->isAdmin()) {
            
            // Bloqueamos estas acciones: ver botón crear, editar, borrar y borrado masivo
            $accionesBloqueadas = [
                Action::CREATE->value,
                Action::UPDATE->value,
                Action::DELETE->value,
                Action::MASS_DELETE->value,
            ];

            if (in_array($ability->value, $accionesBloqueadas)) {
                return false; // No puede hacer estas acciones
            }
        }

        // Para todo lo demás (como ver el listado), dejamos que pase
        return parent::isCan($ability);
    }

    protected function pages(): array
    {
        return [
            MoonShineUserIndexPage::class,
            MoonShineUserFormPage::class,
        ];
    }
}