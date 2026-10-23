<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUserRole;

use App\Models\MoonshineUserRole;
use App\MoonShine\Resources\MoonShineUserRole\Pages\MoonShineUserRoleFormPage;
use App\MoonShine\Resources\MoonShineUserRole\Pages\MoonShineUserRoleIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Ability;
use MoonShine\Support\Enums\Action;

/**
 * @extends ModelResource<MoonshineUserRole, MoonShineUserRoleIndexPage, MoonShineUserRoleFormPage>
 */
class MoonShineUserRoleResource extends ModelResource
{
    protected string $model = MoonshineUserRole::class;

    protected string $title = 'Roles';

    protected string $column = 'name';

    /**
     * Bloquear acciones específicas si no es Admin
     */
    public function isCan(Ability $ability): bool
    {
        if (! auth('moonshine')->user()?->isAdmin()) {
            $accionesBloqueadas = [
                Action::CREATE->value,
                Action::UPDATE->value,
                Action::DELETE->value,
                Action::MASS_DELETE->value,
            ];

            if (in_array($ability->value, $accionesBloqueadas)) {
                return false;
            }
        }

        return parent::isCan($ability);
    }

    protected function pages(): array
    {
        return [
            MoonShineUserRoleIndexPage::class,
            MoonShineUserRoleFormPage::class,
        ];
    }
}