<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUser;

use App\Models\MoonshineUser;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserFormPage;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Ability;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MoonShineUserResource extends ModelResource
{
    protected string $model = MoonshineUser::class;

    protected string $title = 'Admins';

    protected string $column = 'name';

    public function canViewAny(): bool
    {
        return auth('moonshine')->user()?->isAdmin() ?? false;
    }

    public function isCan(Ability $ability): bool
    {
        if (! auth('moonshine')->user()?->isAdmin()) {
            return false;
        }
        
        return parent::isCan($ability);
    }

    /**
     * Sobrescribimos el método query para filtrar SOLO Admins
     */
    protected function query(): Builder
    {
        return parent::query()->where('moonshine_user_role_id', 1);
    }

    protected function pages(): array
    {
        return [
            MoonShineUserIndexPage::class,
            MoonShineUserFormPage::class,
        ];
    }
}